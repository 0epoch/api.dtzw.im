<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    //
    protected $table = 'tags';

    public function stickers()
    {
        return $this->belongsToMany(Sticker::class, 'favorite_sticker', 'favorite_id', 'sticker_id')->withTimestamps();
    }

    /**
     * 表情是否添加到此收藏夹
     * @param $sticker
     */
    public function hasThis($sticker)
    {
        return $this->stickers()->where('sticker_id', $sticker)->count();
    }


    public function followsThis($favoriteId)
    {

    }

}
