<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{

    public function memes()
    {
        return $this->belongsToMany(Meme::class, 'favorite_meme', 'favorite_id', 'meme_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }


    public function hasThis($memeId)
    {
        return $this->memes()->where('meme_id', $memeId)->count();
    }

    /**
     * 表情是否添加到此收藏夹
     * @param $meme
     */
    public function addThis($memeId)
    {

        return $this->memes()->toggle($memeId);
    }


    /**
     * 用户关注--取消关注此收藏夹
     * @param $userId
     * @return int
     */
    // public function followsThis($favoriteId)
    // {
    //     return $this->users()->toggle($favoriteId);
    // }

    /**
     * 用户是否关注此收藏夹
     * @param $userId
     * @return int
     */
    public function followed($userId)
    {
        return $this->users()->where('user_id', $userId)->count();
    }
}
