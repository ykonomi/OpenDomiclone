<?php

namespace App;

use Illuminate\Database\Eloquent\Model; 
class Trash extends Model
{

    public $timestamps = false;
    protected $fillable = ['id', 'card_id', 'name_jp', 'coin_cost', 'card_type', 'description'];

    public function send($card)
    {
        $this->card_id = $card->card_id;
        $this->name_jp = $card->name_jp;
        $this->coin_cost = $card->coin_cost;
        $this->card_type = $card->card_type;
        $this->description = $card->description;
        $this->save();

    }


    //TOOD 差分実装じゃないです
    public function show()
    {
        $trashes = $this->all();
        $index = 0;
        $result = [];

        foreach ($trashes as $card) {
            $result += [$index => 
                ['id'   => $card->card_id, 
                'name' => $card->name_jp, 
                'desc' => $card->description, 
                'cost' => $card->coin_cost, 
                'type' => $card->card_type]];
            $index++;
        }

        return $result;
    }
}
