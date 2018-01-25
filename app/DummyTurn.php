<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DummyTurn extends Model
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
     * 　参加IDをターンテーブルに追加する
     *   重複している場合は追加しない
     *
     *   * 重複チェックをDBに任せるとおそらく面倒
     */
    public function add($id)
    {
        $members = $this->getEntries();

        if (!in_array($id, $members)){
            $this->user_id = $id;
            $this->save();
        }
    }

}
