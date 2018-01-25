<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Card extends Model
{
    public $timestamps = false;

    public function getInfoOf($id)
    {
        $card = $this->find($id);
        $result = ['name' => $card->name_jp,
            'desc' => $card->description, 
            'cost' => $card->coin_cost, 
            'type' => $card->card_type];

        return $result;
    }


    public function isAction($card_type)
    {
        switch($card_type){
            case 'action':
                return true;
            case 'action-attack':
                return true;
            case 'action-reaction':
                return true;
            default:
                return false;
        }
    }
    
}

