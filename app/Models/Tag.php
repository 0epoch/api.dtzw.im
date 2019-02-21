<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public $timestamps = false;
    //标签  - 表情包 多对多关联
    public function memes()
    {
        return $this->belongsToMany('App\Models\Meme', 'meme_tag', 'tag_id', 'meme_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'tag_user', 'tag_id', 'user_id');
    }

    public function followThisTag($id)
    {
        return $this->users()->toggle($id);
    }
}
