<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //标签  - 表情包 多对多关联
    public function stickers()
    {
        return $this->belongsToMany('App\Models\Tag', 'sticker_tag', 'tag_id', 'sticker_id');
    }
}
