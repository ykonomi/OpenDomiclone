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
        
        $this->setText();

        Card::create($this->_make('銅貨','Copper','基本',0,0,0,'基本','treasure',1,0,0,0,0,0,0));
        Card::create($this->_make('銀貨','Silver','基本',3,0,0,'基本','treasure',2,0,0,0,0,0,0));
        Card::create($this->_make('金貨','Gold','基本',6,0,0,'基本','treasure',3,0,0,0,0,0,0));
        Card::create($this->_make('屋敷','Estate','基本',2,0,0,'基本','victory',0,1,0,0,0,0,0));
        Card::create($this->_make('公領','Duchy','基本',5,0,0,'基本','victory',0,3,0,0,0,0,0));
        Card::create($this->_make('属州','Province','基本',8,0,0,'基本','victory',0,6,0,0,0,0,0));
        Card::create($this->_make('呪い','Curse','基本',0,0,0,'基本','curse',0,-1,0,0,0,0,0));
        Card::create($this->_make('冒険者','Adventurer','基本',6,0,0,'王国','action',0,0,0,0,0,0,0));
        Card::create($this->_make('役人','Bureaucrat','基本',4,0,0,'王国','action-attack',0,0,0,0,0,0,0));
        Card::create($this->_make('地下貯蔵庫','Cellar','基本',2,0,0,'王国','action',0,0,0,1,0,0,0));
        Card::create($this->_make('宰相','Chancellor','基本',3,0,0,'王国','action',0,0,0,0,0,2,0));
        Card::create($this->_make('礼拝堂','Chapel','基本',2,0,0,'王国','action',0,0,0,0,0,0,0));
        Card::create($this->_make('議事堂','CouncilRoom','基本',5,0,0,'王国','action',0,0,4,0,1,0,0));
        Card::create($this->_make('祝宴','Feast','基本',4,0,0,'王国','action',0,0,0,0,0,0,0));
        Card::create($this->_make('祝祭','Festival','基本',5,0,0,'王国','action',0,0,0,2,1,2,0));
        Card::create($this->_make('庭園','Gardens','基本',4,0,0,'王国','victory',0,0,0,0,0,0,0));
        Card::create($this->_make('研究所','Laboratory','基本',5,0,0,'王国','action',0,0,2,1,0,0,0));
        Card::create($this->_make('書庫','Library','基本',5,0,0,'王国','action',0,0,0,0,0,0,0));
        Card::create($this->_make('市場','Market','基本',5,0,0,'王国','action',0,0,1,1,1,1,0));
        Card::create($this->_make('民兵','Militia','基本',4,0,0,'王国','action-attack',0,0,0,0,0,2,0));
        Card::create($this->_make('鉱山','Mine','基本',5,0,0,'王国','action',0,0,0,0,0,0,0));
        Card::create($this->_make('堀','Moat','基本',2,0,0,'王国','action-reaction',0,0,2,0,0,0,0));
        Card::create($this->_make('金貸し','Moneylender','基本',4,0,0,'王国','action',0,0,0,0,0,0,0));
        Card::create($this->_make('改築','Remodel','基本',4,0,0,'王国','action',0,0,0,0,0,0,0));
        Card::create($this->_make('鍛冶屋','Smithy','基本',4,0,0,'王国','action',0,0,3,0,0,0,0));
        Card::create($this->_make('密偵','Spy','基本',4,0,0,'王国','action-attack',0,0,1,1,0,0,0));
        Card::create($this->_make('泥棒','Thief','基本',4,0,0,'王国','action-attack',0,0,0,0,0,0,0));
        Card::create($this->_make('玉座の間','ThroneRoom','基本',4,0,0,'王国','action',0,0,0,0,0,0,0));
        Card::create($this->_make('村','Village','基本',3,0,0,'王国','action',0,0,1,2,0,0,0));
        Card::create($this->_make('魔女','Witch','基本',5,0,0,'王国','action-attack',0,0,2,0,0,0,0));
        Card::create($this->_make('木こり','Woodcutter','基本',3,0,0,'王国','action',0,0,0,0,1,2,0));
        Card::create($this->_make('工房','Workshop','基本',3,0,0,'王国','action',0,0,0,0,0,0,0));

    }

    public function setText()
    {
        $this->text = [
            //銅貨、銀貨、金貨、屋敷、公領、属州、呪い
            'Copper' => '', 'Silver' => '', 'Gold' => '', 
            'Estate' => '', 'Duchy' => '', 'Province' => '', 'Curse' => '',

            'Adventurer' => 'あなたの山札から財宝カード２枚が公開されるまで、カードを公開する。'.
                            '公開した財宝カード２枚を手札に加え、他の公開したカードは捨て札に置く',
            'Bureaucrat' => '銀貨１枚を獲得し、あなたの手札の上に置く。'.
                            '他のプレイヤーは全員、自分の手札から勝利点カード１枚を公開し、自分の山札の上に置く。'.
                            '(手札に勝利点カードがない場合、手札を公開する。)',
            'Cellar' => '+1アクション。手札から好きな枚数のカードを捨て札にする。捨て札１枚につき、カードを１枚引く。',
            'Chancellor' => '+2金。あなたの山札のカード全てを、即座に捨て札に置くことができる。',
            'Chapel' => 'あなたの手札から最大４枚までのカードを、廃棄する。',
            'CouncilRoom' => '+4カードを引く +1カードを購入 他のプレイヤー全員は、カードを１枚引く。',
            'Feast' => 'このカードを廃棄する。コスト５以下のカードを１枚を獲得する。',
            'Festival' => '+2アクション。+1カードを購入。+2金',
            'Gardens' => 'あなたの山札のカード１０枚（端数は切り捨て）につき勝利点１を得る。',
            'Laboratory' => '+2 カードを引く +1 アクション',
            'Library' => 'あなたの手札が７枚になるまでカードを引く。'.
                         'この方法で引いたアクションカードを脇に置いても良い。（７枚には数えない。）'.
                         '脇に置いたカードは、このアクションの後、捨て札にする。',
            'Market' => '+1 カードを引く +1 アクション +1 カードを購入 +1金',
            'Militia' => '+2金 他のプレイヤーは全員、自分の手札が３枚になるまで捨て札にする。',
            'Mine' => 'あなたの手札の財宝カード１枚を破棄する。破棄した財宝よりもコストが最大３多い財宝カード１枚を獲得し,あなたの手札に加える。',
            'Moat' => '+2 カードを引く 他のプレイヤーがアタックカードを使用した時、手札からこのカードを公開できる。'.
                      'そうした場合、あなたはそのアタックカードの影響を受けない。',
            'Moneylender' => 'あなたの手札から銅貨１枚を破棄する。そうした場合、+3金を使用できる。',
            'Remodel' => 'あなたの手札のカード１枚を廃棄する。廃棄したカードよりコストが最大２金多いカード１枚を獲得する。',
            'Smithy' => '+3　カードを引く',
            'Spy' => '+1 カードを引く +1 アクション'.
                     ' 各プレイヤー（あなたも含む）は、自分の手札の一番上のカードを公開し、そのカードを捨て札にするかそのまま戻すかをあなたが選ぶ',
            'Thief' => '他のプレイヤーは全員、自分の山札の上から２枚のカードを公開する。'.
                       '財宝カードを公開した場合、その中の１枚をあなたが選んで廃棄する。'.
                       'あなたはここで廃棄したカードのうち好きな枚数を獲得できる。他の公開したカードは全て捨て札にする。',
            'ThroneRoom' => 'あなたの手札のアクションカード１枚を選ぶ。そのカードを２回使用する。',
            'Village' => '+1 カードを引く +2 アクション',
            'Witch' => '+1 カードを引く他のプレイヤーは全員、呪いカードを１枚ずつ獲得する。',
            'Woodcutter' => '+1 カードを購入する +2 金',
            'Workshop' => 'コスト最大4までのカード１枚を獲得する。',
        ];

    }


    private function _make($name_jp, $name_en, $card_set, $coin_cost,
        $coin_potion, $coin_debt, $class, $card_type,
        $coin, $point, $plus_card, $plus_action,
        $plus_buy, $plus_coin, $plus_point){

        return ['name_jp' => $name_jp,
            'name_en'     => $name_en,
            'card_set'    => $card_set,
            'coin_cost'   => $coin_cost,
            'coin_potion' => $coin_potion,
            'coin_debt'   => $coin_debt,
            'class'       => $class,
            'card_type'   => $card_type,
            'coin'        => $coin,
            'point'       => $point,
            'plus_card'   => $plus_card,
            'plus_action' => $plus_action,
            'plus_buy'    => $plus_buy,
            'plus_coin'   => $plus_coin,
            'plus_point'  => $plus_action,
            'description' => $this->text[$name_en],
        ];
    }
}