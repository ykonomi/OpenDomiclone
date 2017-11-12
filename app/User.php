<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

use Exception;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'password', 'coin','updated','deck_top','is_up','hand_top'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //public $timestamps = false;
    
    /**
     *  テストなし
     */
    public function getName($id)
    {
        return $this->find($id)->name;
    }

    /**
     * 　山札を初期化するメソッド
     *   銅貨のカードを7枚、屋敷のカードを3枚用意してシャッフルする
     */
    public function initDeck()
    {
        $copper = 1;  $estate = 4;
        $cards = [$estate, $estate, $estate, $copper, $copper,
                  $copper, $copper, $copper, $copper, $copper];
        shuffle($cards);

        return $cards;

    }

    /**
     *   
     */
    public function show($hand)
    {
        $card = new Card;
        
        $result = [];
        $index = 0;

        foreach ($hand as $id) {
            $result += [$index => $card->getInfoOf($id)];
            $index++;
        }

        return $result;
        
    }


    /**
     *
     */
    public function hasActionCardIn($hands)
    {
        $cardList = new Card();
        foreach ($hands as $cardId) {
            $card = $cardList->find($cardId);
            if ($card->card_type === 'action'){
                return true;
            } elseif ($card->card_type === 'action-attack') {
                return true;
            } elseif ($card->card_type === 'action-reaction'){
                return true;
            }
        }
        return false;
    }

    //手札からカードを取り除き、プレイエリアにカードをだす
    //deprecated
    /*
    public function play($checks)
    {
        $hands = session('hand');
        $cards = [];

        foreach ($checks as $check) {
            array_push($cards, $hands[$check]);
            unset($hands[$check]);
        }
        $hands = array_values($hands);

        $play_area = session('play_area');
        session(['play_area' => array_merge($play_area, $cards),
                 'hand'      => $hands]);
    }*/

    /**
     * テストなし
     */
    public function action($card_id)
    {
        $cardList = new Card();
        $cardName = $cardList->find($card_id)->name_jp;

        $card = new $cardName();
        return $card->action();
    }


    /**
     *
     */
    public function estimate($hands){
        $cardList = new Card();
        $sum = 0;

        foreach ($hands as $hand) {
            $card = $cardList->find($hand);
            $sum += (int) $card->coin;
        }

        return $sum;
    }

    /**
     *
     */
    public function discard($card, $discard)
    {
        array_push($discard, $card);
        return $discard;
    }

    /**
     *
     */
    public function discardArray($cards, $discard)
    {
        return array_merge($cards, $discard);
    }


    //手札を山札$n枚数分引く。山札が枯れた場合、捨て札をシャッフルし、
    //山札にする。そして、足りない分を補充する
    //返り値は　山札、手札、捨て札
    /**
     *
     */

    
    /**
     * テストなし
     */
    public function canDrawInDeck($drawN, $deck){
        $deckN = count($deck);
        return $drawN < $deckN;
    }

    public function drawInDeck($drawN, $deck)
    {
        $deckN = count($deck);

        if ($drawN > $deckN){
            throw new Exception('drawInDeck: 山札を超えてドローしている');
        }
        
        $hand = array_splice($deck, $deckN - $drawN, $drawN);
        return [$hand, $deck];
    }

    public function drawOverDeck($drawN, $discard)
    {
        //捨て札をシャッフルして山札にする。
        shuffle($discard);
        $newDeck = $discard;

        //超えた分を新しい山札から引く
        return $this->drawInDeck($drawN, $newDeck);
        
    }

    public function draw($drawN, $deck, $discard)
    {
        if (!$this->canDrawInDeck($drawN, $deck)){
            $deckN = count($deck);
            list($hand1, $deck1) = $this->drawInDeck($deckN, $deck);
            list($hand2, $deck2) = $this->drawOverDeck($drawN - $deckN, $discard);
            $newHands = array_merge($hand1, $hand2);
            $newDeck = array_merge($deck1, $deck2);
            return [$newHands, $newDeck, []];
        } else {
            list($hand, $deck) = $this->drawInDeck($drawN, $deck);
            return [$hand, $deck, $discard];
        }
    }    


    
    /**
     *
     */
    public function addActionCounts($n)
    {
        $actionN = session('action');
        session(['action' => $actionN + $n]);
    }

    /**
     *
     */
    public function getActionCounts()
    {
        return session('action');
    }

    public function addCoin($n)
    {
        $coin = session('coin');
        session(['coin' => $coin + $n]);
    }

    public function getCoin()
    {
        return session('coin');
        
    }

    public function addBuyCounts($n)
    {
        $buy = session('buy');
        session(['buy' => $buy + $n]);
    }

    public function getBuyCounts()
    {
        return session('buy');
    }

}
    //データベースを編集時にイベントを起こすためのコード
    //イベントが発生させるプロセスとイベントを発生するプロセス
    //が同じであるため、ボツに
    //protected static function boot()
    //{
    //    parent::boot();

    //    self::created(function($model){
    //        return $model->onCreatedHandler();
    //    });
    //}

    //private function onCreatedHandler()
    //{
    //    echo "プレイヤーが追加されました。";

    //}
    //    データベースで操作する場合
    //    //自分の山札の上から5枚取り出す。
    //    $hands = $deck->where('id', '>', $deck_n - $hand_n)->get(); 
    //    
    //    //取り出した5枚を手札にする。
    //    foreach ($hands as $hand) {
    //        $this->create($hand->toArray());
    //        $hand->delete();
    //    }

    //    //auto_increment値を補正
    //    $hand_n++;
    //    DB::update("alter table decks auto_increment = $hand_n;");

    //}
