<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sticker extends Model
{
    // 表情包 - 标签 多对多关联
    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag', 'sticker_tag', 'sticker_id', 'tag_id');
    }

    public function urls()
    {
        return $this->hasMany('App\Models\StickerUrl');
    }
}
