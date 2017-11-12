<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Turn extends Model
{
    protected $fillable = [
        'id', 'user_id'
    ];

    /**
     *   参加者全てのidを取得する
     */
    public function getEntries()
    {
        $ids = [];
        $members = $this->all();
        
        foreach ($members as $member) {
            $ids[] = $member->user_id;
        }

        return $ids;
    }

    /**
     *   IDをシャッフルし、登録する
     */
    public function register($ids)
    {
        $this->truncate();
        shuffle($ids);

        foreach ($ids as $id) {
            $turn = new Turn(); //foreachのたびにnewしないとsaveされないみたい
            $turn->user_id = $id;
            $turn->save();
        }
    }


    /**
     *  　次のターンのユーザーIDを求めるメソッド
     */
    public function next($id)
    {
        
        $entryIds = $this->getEntries();

        $memberN = count($entryIds);
        $next = 0;

        for ($i=0; $i < $memberN; $i++) {
            if ($id == $entryIds[$i]){
                if ($i == $memberN - 1){
                    $next = 0;
                } else {
                    $next = $i + 1;
                }
                break;
            }
        }

        return $this->find($next + 1)->user_id;

        
    }

}
