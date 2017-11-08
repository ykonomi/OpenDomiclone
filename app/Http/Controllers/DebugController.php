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

    public function get_card(Request $request)
    {
        $id = $request->input('id');
        $card = new Card();
        $card = $card->find($id);
        $result = ['name' => $card->name_jp, 'desc' => $card->description, 'cost' => $card->coin_cost, 'type' => $card->card_type];

        return json_encode($result);
    }

    public function get_list(Request $request)
    {
        $result = [];
        $card = new Card();
        $cards = $card->all();

        foreach ($cards as $card) {
            array_push($result, $card->name_en);
        }

        return $result;
        
    }

    public function update_session1()
    {
        $card = new Card;
        session(['debug' => $card->find(2)->coin]);
        
        return json_encode(['updated' => session('debug')]);
    }

    public function update_session2()
    {
        $card = new Card;
        //session(['debug' => $card->find(3)->coin]);
        
        return json_encode(['updated' => session('debug')]);
    }

    public function update_session3()
    {
        $card = new Card;
        session(['debug' => $card->find(3)->coin]);
        
        return json_encode(['updated' => session('debug')]);
    }
}
