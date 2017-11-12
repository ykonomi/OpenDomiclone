<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Card extends Model
{
    public $timestamps = false;

    /*
    public function action($card_name)
    {
        $user = new User();

        switch ($card_name) {
        case 'Adventurer'  :
            break;
        case 'Bureaucrat'  :
            break;
        case 'Cellar'      :
            break;
        case 'Chancellor'  :
            break;
        //礼拝堂
        case 'Chapel'      :


            break;
        case 'CouncilRoom' :
            break;
        case 'Feast'       :
            break;
        case 'Festival'    :
            break;
        case 'Gardens'     :
            break;
        case 'Laboratory'  :
            break;
        case 'Library'     :
            $user->draw(2);
            $user->addAction(1);
            $user->add_action(1);
            break;
        case 'Market'      :
            break;
        case 'Militia'     :
            break;
        case 'Mine'        :
            break;
        case 'Moat'        :
            break;
        case 'Moneylender' :
            break;
        case 'Remodel'     :
            break;
        case 'Spy'         :
            break;
        case 'Thief'       :
            break;
        case 'ThroneRoom'  :
            break;
        case 'Village'     :
            break;
        case 'Witch'       :
            break;
        case 'Woodcutter'  :
            break;
        case 'Workshop'    :
            break;
        default:
        break;
        }
    }
*/
    public function getInfoOf($id)
    {
        $card = $this->find($id);
        $result = ['name' => $card->name_jp, 'desc' => $card->description, 'cost' => $card->coin_cost, 'type' => $card->card_type];

        return $result;
    }


    public function isAction($id)
    {
        return $this->find($id)->card_type !== 'action';
    }
    
    public function action()
    {
        //TOOD エラーを促す
    }
}

//鍛冶屋 カードを +3 枚引く
class Smithy extends Card {
    
    public function action()
    {
        $user = new User();
        $user->draw(3);
    }

}
//'Laboratory' => '+2 カードを引く +1 アクション',
class Laboratory extends Card {
    public function action()
    {
        $user = new User();
        $user->draw(2);
        $user->addActionCounts(1);
    }
}

//'Festival' => '+2アクション。+1カードを購入。+2金',
class Festival extends Card {
    public function action()
    {
        $user = new User();
        $user->addActionCounts(2);
        $user->draw(1);
        $user->addCoin(2);
    }
}

//'Village' => '+1 カードを引く +2 アクション',
class Village extends Card {
    public function action()
    {
        $user = new User();
        $user->draw(1);
        $user->addActionCounts(2);
    }
}
//'Woodcutter' => '+1 カードを購入する +2 金',
class Woodcutter extends Card {
    public function action()
    {
        $user = new User();
        $user->addBuyCounts(1);
        $user->addCoin(2);
    }
}
//'Market' => '+1 カードを引く +1 アクション +1 カードを購入 +1金',
class Market extends Card {
    public function action()
    {
        $user = new User();
        $user->draw(1);
        $user->addActionCounts(1);
        $user->addBuyCounts(1);
        $user->addCoin(1);
    }
}
//'Workshop' => 'コスト最大4までのカード１枚を獲得する。',
class Workshop extends Card {
    public function action()
    {
        $user = new User();
        return "workshop";
    }
}

//'Chapel' => 'あなたの手札から最大４枚までのカードを、廃棄する。',

/* カード用テンプレ
class Smithy extends Card {
    public function action()
    {
        $user = new User();
        $user->draw(3);
    }
}
 *
            'Adventurer' => 'あなたの山札から財宝カード２枚が公開されるまで、カードを公開する。公開した財宝カード２枚を手札に加え、他の公開したカードは捨て札に置く',
            'Bureaucrat' => '銀貨１枚を獲得し、あなたの手札の上に置く。他のプレイヤーは全員、自分の手札から勝利点カード１枚を公開し、自分の山札の上に置く。(手札に勝利点カードがない場合、手札を公開する。)
',
            'Cellar' => '+1アクション。手札から好きな枚数のカードを捨て札にする。捨て札１枚につき、カードを１枚引く。',
            'Chancellor' => '+2金。あなたの山札のカード全てを、即座に捨て札に置くことができる。',
            'CouncilRoom' => '+4カードを引く +1カードを購入 他のプレイヤー全員は、カードを１枚引く。',
            'Feast' => 'このカードを廃棄する。コスト５以下のカードを１枚を獲得する。',
            'Gardens' => 'あなたの山札のカード１０枚（端数は切り捨て）につき勝利点１を得る。',
            'Library' => 'あなたの手札が７枚になるまでカードを引く。この方法で引いたアクションカードを脇に置いても良い。（７枚には数えない。）脇に置いたカードは、このアクションの後、捨て札にする。',
            'Militia' => '+2金 他のプレイヤーは全員、自分の手札が３枚になるまで捨て札にする。',
            'Mine' => 'あなたの手札の財宝カード１枚を破棄する。破棄した財宝よりもコストが最大３多い財宝カード１枚を獲得し,あなたの手札に加える。',
            'Moat' => '+2 カードを引く 他のプレイヤーがアタックカードを使用した時、手札からこのカードを公開できる。そうした場合、あなたはそのアタックカードの影響を受けない。',
            'Moneylender' => 'あなたの手札から銅貨１枚を破棄する。そうした場合、+3金を使用できる。',
            'Remodel' => 'あなたの手札のカード１枚を廃棄する。廃棄したカードよりコストが最大２金多いカード１枚を獲得する。',
            'Spy' => '+1 カードを引く +1 アクション 各プレイヤー（あなたも含む）は、自分の手札の一番上のカードを公開し、そのカードを捨て札にするかそのまま戻すかを
あなたが選ぶ',
            'Thief' => '他のプレイヤーは全員、自分の山札の上から２枚のカードを公開する。財宝カードを公開した場合、その中の１枚をあなたが選んで廃棄する。あなたはここで廃棄したカードのうち好きな枚数を獲得できる。他の公開したカードは全て捨て札にする。',
            'ThroneRoom' => 'あなたの手札のアクションカード１枚を選ぶ。そのカードを２回使用する。',
            'Witch' => '他のプレイヤーは全員、呪いカードを１枚ずつ獲得する。',
 */


/*
 *  工房 祝宴　サプライ
 *  高山　手札　財宝カードの選択
 *   冒険者　公開する　
 *   礼拝堂　手札
 *   議事堂　他のプレイヤはカードを一枚引く
 *  金貸　地下貯蔵庫　手札　
 *　宰相　yes no
    改築　手札　サプライ
    書庫　脇に置きますか
    玉座　手札
  
    〜さんは　のカードを使用しました。
    wait
    カードの説明



    ~さんは　を購入しました。
           何も購入しませんでした


    
 *
 *
 */
