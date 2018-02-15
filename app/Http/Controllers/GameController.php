<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

use App\User;
use App\Supply;
use App\Card;
use App\Trash;
use App\Turn;
use App\DummyTurn;

class GameController extends Controller
{

    private $MEMBER_COUNT = 2;

    public function dummy()
    {
        
    }

    /**
     * 　ゲームへ参加表明するメソッド.
     *   ターンテーブルに自分のidを追加する。
     *   そして、現時点での参加者idを参加者に通知する
     *   
     *   @param Resquest 
     *   @return　
     *   @deprecated
     */
    public function entry(Request $request)
    {
        $id = (int) $request->get('id');
        $turnTable = new DummyTurn();

        $turnTable->add($id);

        //現在の参加メンバ(id)をブロードキャストする
        broadcast(new \App\Events\OtherEntry($turnTable->getEntries()));
    }

    // @deprecated
    public function entryOffline(Request $request)
    {
        $id = (int) $request->get('id');
        $turnTable = new DummyTurn();

        $turnTable->add($id);
    }


    /**
     * ゲームの初期化を行うメソッド。サプライとターンテーブルの初期化を行い、
     * 初期化が終わったことを全てのプレイヤーにブロードキャストする。
     */
    public function create()
    {
        $supply = new Supply();
        $supply->init();

        $turnTable = new Turn();
        $turnTable->init($this->MEMBER_COUNT);

        broadcast(new \App\Events\SettingCompleted());
    }

    // @deprecated
    public function initParent(Request $request)
    {
        $id = $request->get('id');
        $this->initTurn();
        //$this->initUser($id);
        $turnTable = new DummyTurn();

        //$turnTable->add($id);
        broadcast(new \App\Events\SettingCompleted(1));
        //broadcast(new \App\Events\OtherEntry(1));

    }

    // @deprecated
    public function initChild(Request $request)
    {
        $id = $request->get('id');
        $this->initUser($id);
    }

    // @deprecated
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
    // @deprecated
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
    // @deprecated
    private function initUser()
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


    public function getHandsAndPlayArea()
    {
        $user = new User();
        $hands = session('hand');
        $playArea = session('play_area');
        
        return ['hands'    => $user->show($hands),
            'playarea' => $user->show($playArea)];
    }



    public function showHands()
    {
        $user = new User();
        $hands = session('hand');
        
        return ['ui' => $user->show($hands)];
    }

    public function showSupplies(Request $request)
    {
        $supply = new Supply();
        return ['ui' => $supply->show()];
    }

    public function showPlayArea()
    {
        $user = new User();
        $playArea = session('play_area');
        
        return (['ui' => $user->show($playArea)]);
    }

    public function showTrashes()
    {
        $trash = new Trash();
        return (['ui' => $trash->show()]);
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

        $result = $user->hasActionCardIn($hands);

        if ($result){
            $log = 'アクションカードを選択してね。';
        } else {
            $log = 'アクションカードがないため、フェイズを飛ばします。';
        }

        return ['result' => $result, 'log' => $log];
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

        $result = $cardList->isAction($card_type);

        if ($result) {
            $log = 'アクションカードをプレイします。';
        } else {
            $log = 'それはアクションカードではありません。';
        }
        return ['result' => $result, 'log' => $log];
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

        //plus系のアクション効果の処理
        list($n, $plusAction, $plusBuy, $plusCoin) = $user->action($card_id);
        $this->addActionCounts($plusAction);
        $this->addBuyCounts($plusBuy);
        $this->addUserCoins($plusCoin);
        $this->drawWithSessions($n);


        $action_count =  session('action_count') - 1;
        session(['action_count' => $action_count]);


        //とりあえずここを肥やす
        //魔女実装
        if ($card_id == 29){
            $card = new Card();
            $this->attack($card->find($card_id));
        //礼拝堂の実装。
        } else if ($card_id == 12){
            return ['action_count' => $action_count,
                'log'          => '廃棄するカードを４枚選択してください',
                'pattern'      => 1,
                'plus_buy' => $this->getUserCoins()];
        } else {
            return ['action_count' => $action_count,
                'plus_buy' => $this->getUserCoins()];
        }
    }

    //とりあえず魔女のみ
    public function attack($card)
    {
        broadcast(new \App\Events\Attack($card));
        
    }

    public function drawWithSessions($n){
        $user = new User();
        $hand1 = session('hand');
        $deck = session('deck');
        $discard = session('discard');

        list ($hand2, $deck, $discard) = $user->draw($n, $deck, $discard);

        $hand = array_merge($hand1, $hand2);
        session(['deck' => $deck, 'hand' => $hand, 'discard' => $discard]);
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

    private function subUserCoins($n){
        $coin = session('coin');
        session(['coin' => $coin - $n]);
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

        $result = $cache >= $end;

        if ($result){
            $message = "財宝カードを選択してください。";
        } else {
            $message = "そのカードは高くて買えません。";
        }
        //コストが0のとき
        return ['result'  => $result, 'is_zero' => $end === 0, 'message' => $message];

    }

    public function checkSelectedCards(Request $request)
    {
        $card = new Card();
        $checks = $request->input('checks');
        $buyId = (int) $request->input('id');
        $plusBuy = (int) $request->input('plusBuy'); 

        //validation (TODO laravelの力を使う)
        //$plusBuy <= $this->getUserCoins();

        //コスト0のカードを選択したとき
        if(empty($checks) && $card->find($buyId)->card_cost == 0){
            return (['result' => true, 'log' => 'カードを購入しました']);
        }

        $hands = session('hand');
        //選択したカードにTreasureカード以外が混ざっているとき
        //TODO のち複合カードにも対応できるようにする
        foreach ($checks as $cardIdx) {
            if($card->find($hands[(int) $cardIdx])->card_type != 'treasure'){
                return (['result' => false,
                    'log' => '財宝カード以外は使用できません']);
            }
        }

        $coin = 0;
        foreach ($checks as $idx) {
            $coin += $card->find($hands[(int) $idx])->coin;
        }
        $coin += $plusBuy;// $this->getUserCoins();

        $end = $card->find($buyId)->coin_cost;
        
        if ($end <= $coin){
            return (['result' => true,
                                'log' => 'カードを購入しました']);
        } else {
            return (['result' => false,
                                'log' => 'コインが足りません']);
        }

    }

    public function buy(Request $request)
    {
        $user = new User();

        $checks = $request->input('checks');
        $cardId = (int) $request->input('id');
        $plusBuy = (int) $request->input('plusBuy'); 
        $coin = $this->getUserCoins(); 

    
        //+金で買うか、コスト0のカードを買うとき 
        if(!empty($checks)) {
            //手札から購入に使うカードを取り除き、プレイエリアにだす
            $this->play($checks);
        }
            
        //購入したカードを捨て札に置く
        $discard = session('discard');
        session(['discard' => $user->discard($cardId, $discard)]);

        //サプライの数から一枚減らす
        $supply = new Supply();
        $supply->draw($cardId);

        //+金を減らす
        $this->subUserCoins($plusBuy); 

        //ゲーム終了判定
        //サプライが一枚枯れた上で、終了条件を満たすか
        if($supply->isGone($cardId) && $this->isOver($cardId)){
            //comming soon ...
            //終了をブロードキャストする
            //broadcast(new \App\Events\GameOver());
            //return (['end' => true]);
        }
    
        //購入可能回数を1減らす
        $buy_count =  session('buy_count') - 1;
        session(['buy_count' => $buy_count]);
        return (['buy_count' => $buy_count,
            'is_gone' => $supply->isGone($cardId),
            'card_id' => $cardId,
            'rest_coin' => $coin - $plusBuy]);
    }

    public function isOver($cardId){
        $supply = new Supply();
        $supply->isEmptyThreeTimes() || $cardId == 6;
    }


    public function clean()
    {
        $user = new User();
        $hand = session('hand');
        $deck = session('deck');
        $playArea = session('play_area');
        $discard = session('discard');

        // play_areaのカードを捨てる
        $discard = $user->discardArray($playArea, $discard);
        // 自分の手札を捨てる
        $discard = $user->discardArray($hand, $discard);
        // 山札から５枚手札に補充する   
        list ($hand, $deck, $discard) = $user->draw(5, $deck, $discard);

        session(['deck' => $deck,
            'hand' => $hand, 
            'discard' => $discard,
            'play_area' => []]);

        session(['coin' => 0]);
        session(['action_count' => 1]);
        session(['buy_count'    => 1]);
    }


    public function exitGame()
    {
        $user = new User();
        $hands = session('hand');
        $deck  = session('deck');

        $vp = $user->calcVictory($hands, $deck);
        //TODO to be implemented broadcast.

    }


}
