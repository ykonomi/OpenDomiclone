<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

use App\Turn;

class TurnController extends Controller
{

    /**
     *　現プレイヤーかを確認するメソッド
     *  セキュリティの都合による
     */
    public function is_player(){

        $turns = new Turn();
        return ['is_player' => $turns->is_player(session('player_id'))];
    }


}
