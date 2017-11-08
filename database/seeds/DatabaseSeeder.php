<?php
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Card;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard(); 
        $this->call('CardSeeder');
        Model::reguard();

    }
}

class CardSeeder extends Seeder
{

    private $text;

    public function run()
    {
        DB::table('cards')->truncate();
        $this->text = $this->_get();

        Card::create($this->_make('金','Money',1,'coin',2,0));
        Card::create($this->_make('勝点','VP',5,'vp',0,3));
        Card::create($this->_make('アクション券','ActionDummy',2,'action',0,0));
        Card::create($this->_make('購入券','BuyDummy',2,'action',0,0));
        Card::create($this->_make('手札券','AddDummy',2,'action',0,0));
        Card::create($this->_make('コイン券','CoinDummy',2,'action',0,0));
    }

    private function _make($name_jp, $name_en,$coin_cost, $card_type, $coin, $point){

        return ['name_jp' => $name_jp,
            'name_en'   => $name_en,
            'coin_cost'   => $coin_cost,
            'card_type'   => $card_type,
            'coin'        => $coin,
            'point'       => $point,
            'description' => $this->text[$name_en]
        ];
    }

    private function _get(){
        return [
            'Money' => '2金',
            'VP' => '3勝利点',
            'ActionDummy' => 'アクション権を1追加する',
            'BuyDummy' => '購入権を1追加する',
            'AddDummy' => '手札を1枚追加する',
            'CoinDummy' => 'コインを1追加する',
        ];

    }

}
