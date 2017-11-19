<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Card;

class Supply extends Model
{
    public $timestamps = false;
    protected $fillable = ['id', 'name_jp', 'coin_cost', 'card_type', 'description', 'rest'];

    public function init()
    {
        $card_list = new Card();

        //サプライのテーブルを削除
        $this->truncate();

        //基本セットの追加
        $basedSupplies = [1,2,3,4,5,6];
        $baseRest      = [60,40,30,12,12,12];

        foreach ($basedSupplies as $id) {
            $card = $card_list->find($id);
            $this->create(['id' => $id, 
                'name_jp' => $card->name_jp,
                'coin_cost' => $card->coin_cost,
                'card_type' => $card->card_type,
                'description' => $card->description,
                'rest' => $baseRest[$id - 1]
            ]);
        }


        //サプライの初期化(TODO ランダム化)
        //31 29 25 19 17 15 1 2 3 4 5
        $supplies = [31,29,25,19,17,15];

        foreach ($supplies as $id) {
            $card = $card_list->find($id);
            $this->create(['id' => $id, 
                'name_jp' => $card->name_jp,
                'coin_cost' => $card->coin_cost,
                'card_type' => $card->card_type,
                'description' => $card->description,
                'rest' => 10
            ]);
        }
    }

    public function show()
    {
        $supplies = $this->all();
        $index = 0;
        $result = [];

        foreach ($supplies as $card) {
            if ($card->rest == 0) continue;
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

    public function draw($cardId)
    {
        $card = $this->find($cardId);
        $rest = $card->rest - 1;
        if ($rest == 0){
            //ゲーム終了
            if ($cardId == 6 || $this->isEmptyThreeTimes){
                return true;
            }
        }

        $card->rest = $rest;
        $card->save();
        
        return false;
    }

    public function isEmptyThreeTimes()
    {
        $supplies = $this->all();

        $count = 0;
        foreach ($supplies as $card) {
            if ($card->rest == 0){
                $count++;
            }
        }
        
        return $count >= 3;
    }

}
