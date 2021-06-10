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
        'id', 'name', 'password', 'coin','updated','deck_top','is_up','hand_top', 'email',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
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
            if ($cardList->isAction($card->card_type)){
                return true;
            }
        }
        return false;
    }

    //手札からカードを取り除き、プレイエリアにカードをだす
    public function play($target, $hands){
        $newHands     = [];
        $newPlayArea = [];
        $i = 0;
        foreach ($hands as $card) {
            if (!in_array($i, $target)) {
                array_push($newHands, $hands[$i]);
            } else {
                array_push($newPlayArea, $hands[$i]);
            }
            $i++;
        }
        return [$newHands, $newPlayArea];
    }

    /**
     * テストなし
     */
    public function action($card_id)
    {
        $cardList = new Card();
        $card = $cardList->find($card_id);

        $name = $card->name_en;

        return [$card->plus_card,
            $card->plus_action,
            $card->plus_buy,
            $card->plus_coin,
            $card->plus_point];
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
     * テストなし
     */
    public function canDrawInDeck($drawN, $deck){
        $deckN = count($deck);
        return $drawN <= $deckN;
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

    //手札はカードID順でソートする
    public function draw($drawN, $deck, $discard)
    {
        if (!$this->canDrawInDeck($drawN, $deck)){
            $deckN = count($deck);
            list($hand1, $deck1) = $this->drawInDeck($deckN, $deck);
            list($hand2, $deck2) = $this->drawOverDeck($drawN - $deckN, $discard);
            $newHands = array_merge($hand1, $hand2);
            $newDeck = array_merge($deck1, $deck2);
            sort($newHands);
            return [$newHands, $newDeck, []];
        } else {
            list($hand, $deck) = $this->drawInDeck($drawN, $deck);
            sort($hand);
            return [$hand, $deck, $discard];
        }
    }    


    public function calcVictory($hands, $deck)
    {
        $total = 0;
        $card = new Card();
        //手札の勝利点を集計する
        foreach ($hands as $card_id) {
            $total += $card->find($card_id)->point;
        }

        //山札の勝利点を集計する
        foreach ($deck as $card_id) {
            $total += $card->find($card_id)->point;
        }
        //脇に寄せた分の勝利点を集計する(海辺以降)
        return $total;
    }
    

}
