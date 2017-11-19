<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Supply;
use App\Card;
use App\Turn;
use App\DummyTurn;

class DominionAPIController extends Controller
{

    /**
     * 　ゲームへ参加表明するメソッド.
     *   ターンテーブルに自分のidを追加する。
     *   そして、現時点での参加者idを参加者に通知する
     */
    public function entry(Request $request)
    {
        $id = (int) $request->get('id');
        $turnTable = new DummyTurn();

        $turnTable->add($id);

        //現在の参加メンバ(id)をブロードキャストする
        broadcast(new \App\Events\OtherEntry($turnTable->getEntries()));
    }

    public function entryOffline(Request $request)
    {
        $id = (int) $request->get('id');
        $turnTable = new DummyTurn();

        $turnTable->add($id);
    }


    public function initParent(Request $request)
    {
        $id = $request->get('id');
        $this->initTurn();
        $this->initUser($id);
        
    }

    public function initChild(Request $request)
    {
        $id = $request->get('id');
        $this->initUser($id);
    }

    public function getName(Request $request)
    {
        $user = new User();
        $id = (int) $request->get('id');

        return $user->getName($id);
    }


    /**
     *  ゲーム全体を初期化するメソッド
     *  サプライの初期化とターンテーブルの初期化を行う。
     *  ターンテーブルの初期化はシャッフルで行う
     */
    private function initTurn()
    {
        $supply = new Supply();
        $supply->init();

        $dummyTurnTable = new DummyTurn();
        $ids = $dummyTurnTable->getEntries();

        $turnTable = new Turn();
        $turnTable->register($ids);

        $dummyTurnTable->truncate();
    }

    //プレイヤーの山札、手札、捨て札、プレイエリアを初期化
    private function initUser($id)
    {
        $user = new User();

        session(['player_id' => $id]);
        session(['play_area' => []]);
        session(['coin' => 0]);
        session(['action_count' => 1]);
        session(['buy_count'    => 1]);


        //山札を初期化して、上から５枚取り出す。
        $deck = $user->initDeck();
        list ($hand, $deck, $discard) = $user->draw(5, $deck, []);

        session(['deck' => $deck]);
        session(['hand' => $hand]);
        session(['discard' => $discard]); //discard may be empty.

    }

    public function exitTurn(Request $request)
    {
        session(['coin' => 0]);
        session(['action_count' => 1]);
        session(['buy_count'    => 1]);

        $id = $request->input('id');
        $turnTable = new Turn();
        //$next_id = $turnTable->next($id);
        //broadcast(new \App\Events\TurnChange($next_id));
    }

    public function showHands()
    {
        $user = new User();
        $hands = session('hand');
        
        return json_encode(['ui' => $user->show($hands)]);
    }

    public function showSupplies(Request $request)
    {
        $supply = new Supply();
        return json_encode(['ui' => $supply->show()]);
    }

    public function showPlayArea()
    {
        $user = new User();
        $playArea = session('play_area');
        
        return json_encode(['ui' => $user->show($playArea)]);
    }

    public function play($cardIndices)
    {
        $user = new User();
        $hand = session('hand');
        $playarea = session('play_area');
        list($newHand, $newPlayArea) = $user->play($cardIndices, $hand);
        session(['hand' => $newHand]);
        session(['play_area' => array_merge($newPlayArea, $playarea)]);
    }

    public function containActionCards()
    {
        $user = new User();
        $hands = session('hand');

        return json_encode(['result' => $user->hasActionCardIn($hands)]);
    }


    /**
     *  選択した手札がアクションカードかを判断するメソッド
     */
    public function isActionCards(Request $request)
    {
        $index = $request->input('idx');
        $card_id = $this->getCardInHand($index);

        $cardList = new Card();
        $card_type = $cardList->find($card_id)->card_type;
        return json_encode(['result' => $cardList->isAction($card_type)]);
    }

    /**
     * n 番目の手札のカードIDを取得するメソッド
     */
    private function getCardInHand($n)
    {
        $hands = session('hand');
        return $hands[$n];
    }
    /**
     * n 番目の手札を取り除くメソッド
     */
    private function removeCardInHand($n)
    {
        $hands = session('hand');
        array_splice($hands, $n, 1);
        session(['hand' => $hands]);
    }

    private function setPlayArea($n){
        $playArea = session('play_area');
        $card_id = $this->getCardInHand($n);
        array_push($playArea, $card_id);

        session(['play_area' => $playArea]);
    }

    /**
     * アクションカードをプレイするメソッド
     * 処理の順番は 手札から取り出す　プレイエリアにおく　アクションを行う
     * 手札から取り出す処理は破壊的
     */
    public function action(Request $request)
    {
        $user = new User();
        $index = $request->input('idx');

        $card_id = $this->getCardInHand($index);
        //アクションカードを場に置く
        $this->play([$index]);

        //実際のアクション TODOリファクタリング
        list($pcard, $paction, $pbuy, $pcoin) = $user->action($card_id);

        $this->addActionCounts($paction);
        $this->addBuyCounts($pbuy);
        $this->addUserCoins($pcoin);

        $hand_ = session('hand');
        $deck = session('deck');
        $discard = session('discard');

        list ($hand, $deck, $discard) = $user->draw($pcard, $deck, $discard);
        $hand = array_merge($hand_, $hand);
        session(['deck' => $deck]);
        session(['hand' => $hand]);
        session(['discard' => $discard]); 


        $action_count =  session('action_count') - 1;
        session(['action_count' => $action_count]);


        return json_encode(['action_count' => $action_count]);
    }


    private function addActionCounts($n)
    {
        $actionN = session('action_count');
        session(['action_count' => $actionN + (int) $n]);
    }

    private function getActionCounts()
    {
        return session('action_count');
    }

    private function addBuyCounts($n)
    {
        $buy = session('buy_count');
        session(['buy_count' => $buy + $n]);
    }

    private function getBuyCounts()
    {
        return session('buy_count');
    }

    private function addUserCoins($n){
        $coin = session('coin');
        session(['coin' => $coin + $n]);
    }
    
    private function getUserCoins()
    {
        return session('coin');
    }

    public function estimate(Request $request)
    {
        $card = new Card();
        $user = new User();

        $hands = session('hand');

        $cardId = (int) $request->input('id');

        $cache = $user->estimate($hands) + $this->getUserCoins();
        $end = $card->find($cardId)->coin_cost;

        return json_encode(['result' => $cache >= $end]);

    }

    public function checkSelectedCards(Request $request)
    {

        $checks = $request->input('checks');
        //空の時は終了
        if(empty($checks)) return;

        $card_id = (int) $request->input('id');

        $card = new Card();
        $hands = session('hand');
        $coin = 0;
        foreach ($checks as $idx) {
            $coin += $card->find($hands[(int) $idx])->coin;
        }
        $coin += $this->getUserCoins();

        $end = $card->find($card_id)->coin_cost;
        

        return json_encode(['result' => $end <= $coin]);
    }

    public function buy(Request $request)
    {
        $user = new User();

        $checks = $request->input('checks');
        //空の時は終了
        if(empty($checks)) return;

        //手札から購入に使うカードを取り除き、プレイエリアにだす
        $this->play($checks);

        //購入したカードを捨て札に置く
        $cardId = (int) $request->input('id');
        $discard = session('discard');
        session(['discard' => $user->discard($cardId, $discard)]);

        //サプライの数から一枚減らす
        $supply = new Supply();
        $isOver = $supply->draw($cardId);

        //ゲーム終了判定
        if($isOver){
            //終了をブロードキャストする
            broadcast(new \App\Events\GameOver());
            $this->count();
        }
        
        //購入可能回数を1減らす
        $buy_count =  session('buy_count') - 1;
        session(['buy_count' => $buy_count]);

        return json_encode(['buy_count' => $buy_count]);
    }


    public function clean(Request $request)
    {
        $user = new User();
        // play_areaのカードを捨てる
        $playArea = session('play_area');
        $discard = session('discard');
        session(['discard'   => $user->discardArray($playArea, $discard),
                 'play_area' => []]);

        // 自分の手札を捨てる
        $hand = session('hand');
        $discard = session('discard');
        session(['discard' => $user->discardArray($hand, $discard), 
                 'hand'    => []]);

        // 山札から５枚手札に補充する   
        $deck = session('deck');
        $discard = session('discard');
        list ($hand, $deck, $discard) = $user->draw(5, $deck, $discard);
        session(['deck' => $deck, 'hand' => $hand, 'discard' => $discard]);
    }

    public function total()
    {
        //手札の勝利点を集計する
        //山札の勝利点を集計する
        //脇に寄せた分の勝利点を集計する
        
    }

    public function exitGame()
    {

    }


}
