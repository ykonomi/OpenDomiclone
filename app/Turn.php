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
    public function get_entries()
    {
        $ids = [];
        $members = $this->all();
        
        foreach ($members as $member) {
            $ids[] = $member->user_id;
        }

        return $ids;
    }

    /**
     * 　参加IDをターンテーブルに追加する
     *   重複している場合は追加しない
     *
     *   * 重複チェックをDBに任せるとおそらく面倒
     */
    public function add($id)
    {
        $members = $this->get_entries();

        if (!in_array($id, $members)){
            $this->user_id = $id;
            $this->save();
        }
    }

    /**
     *   参加者テーブルをシャッフルで並べなおす。     
     */
    public function relocate()
    {
        $ids = $this->get_entries();

        shuffle($ids);

        $this->truncate();

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
        
        $entryIds = $this->get_entries();

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
