<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meme extends Model
{
    // public $timestamps = false;
    // 表情包 - 标签 多对多关联
    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag', 'meme_tag', 'meme_id', 'tag_id');
    }

    public function paths()
    {
        return $this->hasMany('App\Models\MemePath');
    }
}
