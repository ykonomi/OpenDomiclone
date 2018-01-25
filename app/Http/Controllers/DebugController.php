<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Card;

class DebugController extends Controller
{
    //for Debug
    public function init()
    {
        $id = Auth::id();
        $this->init_player_local($id);

    }

    private function init_player_local($id)
    {
        $user = new User();
        $user->init($id);
    }

    public function get_id()
    {
        return Auth::id();
    }

    public function get_hand()
    {
        return session('hand');
    }

    public function get_deck()
    {
        return session('deck');
    }

    public function get_discard()
    {
        return session('discard');
    }
    
    public function get_playarea()
    {
        return session('play_area');
    }
    public function get_coin()
    {
        return session('coin');
    }
    public function get_action_counts()
    {
        return session('action_count');
    }
    public function get_buy_counts()
    {
        return session('buy_count');
    }

    public function getPlayAreaInfo(){
        $cardList = new Card();
        $playarea = session('play_area');

        $result = [];
        $index = 0;

        foreach ($playarea as $card) {
            $cardList->getInfoOf($card);
            $result += [$index => $card->getInfoOf($id)];
            $index++;
        }

        return json_encode(['ui' => $result]);
    }

}
