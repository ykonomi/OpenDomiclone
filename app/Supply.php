<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Card;

class Supply extends Model
{
    public $timestamps = false;
    protected $fillable = ['id', 'name_jp', 'name_en', 'card_set',
        'coin_cost', 'coin_potion', 'coin_debt',
        'class','card_type','coin','point',
        'plus_card', 'plus_action','plus_buy','plus_coin','plus_point', 'description'];

    public function init()
    {
        $card_list = new Card();

        //サプライのテーブルを削除
        $this->truncate();

        //サプライの初期化(TODO ランダム化)
        //31 29 25 19 17 15 1 2 3 4 5
        $supply = [1,2,3,4,5,6,31,29,25,19,17,15];
        foreach ($supply as $id) {
            $card = $card_list->find($id);
            $this->create($card->toArray());
        }
    }

    public function show()
    {
        $supplies = $this->all();
        $index = 0;
        $result = [];

        foreach ($supplies as $card) {
            $result += [$index => 
               ['id'   => $card->id, 
                'name' => $card->name_jp, 
                'desc' => $card->description, 
                'cost' => $card->coin_cost, 
                'type' => $card->card_type]];
            $index++;
        }

        return $result;
    }

}
