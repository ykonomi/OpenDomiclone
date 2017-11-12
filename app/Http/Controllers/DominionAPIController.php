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

        //既に登録されているか関係なく参加idを通知する
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
        session(['play_area' => [1,2,3]]);
        session(['coin' => 0]);
        session(['action' => 1]);
        session(['buy'    => 1]);


        //山札を初期化して、上から５枚取り出す。
        $deck = $user->initDeck();
        list ($hand, $deck, $discard) = $user->draw(5, $deck, []);

        session(['deck' => $deck]);
        session(['hand' => $hand]);
        session(['discard' => $discard]); //discard may be empty.

    }

    public function exitTurn(Request $request)
    {
        $id = $request->input('id');
        $turnTable = new Turn();

        $next_id = $turnTable->next($id);

        session(['coin' => 0]);
        session(['action' => 1]);
        session(['buy'    => 1]);
        session(['end'    => 0]);

        broadcast(new \App\Events\TurnChange($next_id));
    }

    public function start(Request $request)
    {
        $start_id = $request->get('start_id');

        return view("main", compact("start_id")); 
        
    }

    public function containActionCards()
    {
        $user = new User();
        $hands = session('hand');

        return json_encode(['result' => $user->hasActionCardIn($hands)]);
    }

    public function showHands()
    {
        $user = new User();
        $hands = session('hand');
        

        return json_encode(['ui'       => $user->show($hands),
                            'action_n' => $user->getActionCounts()]);
    }

    public function showSupplies(Request $request)
    {
        $supply = new Supply();
        return json_encode(['ui' => $supply->show()]);
    }


    /**
     *  選択した手札がアクションカードかを判断するメソッド
     */
    public function isActionCards(Request $request)
    {
        $index = $request->input('idx');
        $card_id = getCardInHand($index);

        $cardList = new Card();
        return json_encode(['result' => $cardList->isAction($card_id)]);
    }

    /**
     * n 番目の手札をとるメソッド
     */
    private function getCardInHand($n)
    {
        $hands = session('hand');
        return $hand[$n];
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

        //アクションカードをプレイする。
        $this->removeCardInHand($index);
        $this->setPlayArea($index);

        return json_encode(['event' => $user->action($card_id)]);
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
        $card_id = (int) $request->input('id');


        $card = new Card();
        $hands = session('hand');

        $coin = 0;
        foreach ($checks as $idx) {
            $coin += $card->find($hands[(int) $idx])->coin;
        }

        $end = $card->find($card_id)->coin_cost;
        

        return json_encode(['result' => $end <= $coin]);
    }

    public function buy(Request $request)
    {
        $user = new User();

        //手札から購入に使うカードを取り除き、プレイエリアにだす
        $checks = $request->input('checks');
        $user->play($checks);

        //購入したカードを捨て札に置く
        $cardId = (int) $request->input('id');
        $discard = session('discard');
        session(['discard' => $user->discard($cardId, $discard)]);

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
        $hands = session('hand');
        $discard = session('discard');
        session(['discard' => $user->discardArray($hand, $discard), 
                 'hand'    => []]);

        // 山札から５枚手札に補充する   
        $deck = session('deck');
        $discard = session('discard');
        list ($deck, $hand, $discard) = $user->draw(5, $deck, $discard);
        session(['deck' => $deck, 'hand' => $hand, 'discard' => $discard]);
    }


}
