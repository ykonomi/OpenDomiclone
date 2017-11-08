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
        $result = ['name' => $card->name_jp, 
            'desc' => $card->description, 
            'cost' => $card->coin_cost, 
            'type' => $card->card_type];

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

//アクションダミー
class ActionDummy extends Card {
    public function action()
    {
        $user = new User();
        $user->addActionCounts(1);
    }
}
//コインダミー
class CoinDummy extends Card {
    public function action()
    {
        $user = new User();
        $user->addCoin(1);
    }
}
//手札ダミー
class AddDummy extends Card {
    public function action()
    {
        $user = new User();
        $user->draw(1);
    }
}
//購入ダミー
class BuyDummy extends Card {
    public function action()
    {
        $user = new User();
        $user->addBuy(1);
    }
}
