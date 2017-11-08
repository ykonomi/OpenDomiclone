<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;

class UserTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */


    //TODO: ランダム性
    public function testInitDeck()
    {
        $user = new User();
        $deck = $user->initDeck();
        $this->assertEquals(count($deck), 10);

        $copperCount = 0;
        $estateCount = 0;

        foreach ($deck as $card) {
            //銅貨 or 屋敷
            $this->assertContains($card, [1, 4]);
            if ($card === 1){
                $copperCount++;
            } elseif ($card === 4) {
                $estateCount++;
            }
        }

        //山札の中で銅貨の枚数が７枚、屋敷の枚数が３枚であること
        $this->assertEquals($copperCount, 7);
        $this->assertEquals($estateCount, 3);
    }

    /**
     * @dataProvider handProvider 
     * TOOD: もっとましなのを
     */
    public function testShow($hand, $expected)
    {
        
        $this->assertEquals(1,1);
        $user = new User;
        //var_dump($user->show($hand));
   //     $this->assertEquals($user->show($hand), $expected);

    }

    public function handProvider()
    {
        return [
            [[1,2,3,4,5], [0,0,0,0,0]],
        ];
    }


    /**
     * @dataProvider hasActionCardInProvider 
     *  8 アクションカード
     *  9 アクションアタックカード
     *  22はアクションリアクションカード
     */
    public function testHasActionCardIn($hands, $expected)
    {
        $user = new User();
        $this->assertEquals($user->hasActionCardIn($hands), $expected);

    }

    public function hasActionCardInProvider()
    {
        return [
            [[], false],
            [[1,2], false],
            [[8], true],
            [[1,2,3,4,5,6,9], true],
            [[1,2,3,7,5,6,22], true],
        ];
    }    

    /**
     *  @dataProvider estimateProvider
     *
     */
    public function testEstimate($hands, $expected)
    {
        $user = new User();
        $this->assertEquals($user->estimate($hands), $expected);
        
    }

    public function estimateProvider()
    {
        return [
            [[], 0],
            [[1,2,3,4,5], 6],
            [[26,28,30,32], 0],
        ];
    }
    

    /**
     *  @dataProvider discardProvider
     *
     */
    public function testDiscard($card, $discard, $expected)
    {
        $user = new User();
        $this->assertEquals($user->discard($card, $discard), $expected);
    }
    public function discardProvider()
    {
        return [
            [1, [], [1]],
            [1, [2], [2,1]],
            [3, [1,2], [1,2,3]]
        ];
    }


    /**
     *  @dataProvider discardArrayProvider
     *
     */
    public function testDiscardArray($cards, $discard, $expected)
    {
        $user = new User();
        $this->assertEquals($user->discardArray($cards, $discard), $expected);
    }
    public function discardArrayProvider()
    {
        return [
            [[],[],[]],
            [[1],[],[1]],
            [[1,2],[],[1,2]],
            [[1,2],[3],[1,2,3]],
            [[1,2],[3,4],[1,2,3,4]],
        ];
    }

    /**
     *  @dataProvider drawInDeckProvider
     *
     */
    public function testDrawInDeck($drawN, $deck, $expected)
    {
        $user = new User();
        $this->assertEquals($user->drawInDeck($drawN, $deck), $expected);
    }
    /**
     *  @expectedException Exception
     *
     */
    public function testDrawInDeckException()
    {
        $user = new User();
        $this->assertEquals($user->drawInDeck(2, [1]), [9999]);

    }
    public function drawInDeckProvider()
    {
        return [
            [0,[1,2],[[],[1,2]]],
            [1,[1,2],[[2],[1]]],
            [2,[1,2],[[1,2],[]]],
            [7,[1,2,1,1,1,1,1,1,4],[[1,1,1,1,1,1,4],[1,2]]],
        ];
    }

    /**
     *  @dataProvider drawOverDeckProvider
     *
     */
    public function testDrawOverDeck($n, $discard, $expected)
    {
        $user = new User();
        list($hand, $deck) = $user->drawOverDeck($n, $discard);
        //数が合っているか
        $this->assertEquals(count($hand), $n);
        $this->assertEquals(count($deck), count($discard) - $n);

        //内容が合っているか
        $merge = array_merge($hand, $deck);
        sort($merge);
        $this->assertEquals($merge, $expected);

    }
    public function drawOverDeckProvider()
    {
        return [
            [0,[1,2,3,4,5],[1,2,3,4,5]],
            [3,[4,3,2,1],[1,2,3,4]],
            [5,[3,4,6,2,8],[2,3,4,6,8]],
        ];
    }

    /**
     *  @dataProvider drawProvider
     *
        //異常系は考えない
     */
    public function testDraw($n, $deck, $discard, $expected)
    {
        $user = new User();
        $this->assertEquals($user->draw($n, $deck, $discard), $expected);
    }
    public function drawProvider()
    {
        return [
            [0,[1,2,3,4,5],[],[[],[1,2,3,4,5],[]]],
            [0,[1,2,3,4,5],[1],[[],[1,2,3,4,5],[1]]],
            [1,[1,2,3,4,5],[],[[5],[1,2,3,4],[]]],
            [1,[1,2,3,4,5],[1],[[5],[1,2,3,4],[1]]],
            [4,[1,2,3,4,5],[1],[[2,3,4,5],[1],[1]]],
            [6,[1,2,3,4,5],[1],[[1,2,3,4,5,1],[],[]]],
            //[6,[1,2,3,4,5],[1,2],[[1,2,3,4,5,2],[1],[]]],
        ];
    }

}
