<?php

namespace App\Repository;

use App\Models\Favorite;

class FavoriteRepository
{

    /**
     * 写入新建收藏夹
     * @param $attr
     */
    public function saveFavorite($attr)
    {
        $user = auth('api')->user();
        $favorite = new Favorite();
        $favorite->name = $attr['name'];
        $favorite->user_id = 1;
        $favorite->author = 'test';
        $favorite->description = $attr['description'];
        $favorite->is_private = isset($attr['isPrivate']) ? $attr['isPrivate'] : 'N';
        $favorite->save();
        return $favorite;
    }

    /**
     * 写入关注收藏夹用户
     * @param $favoriteId
     * @param $userId
     * @return bool
     */
    public function saveFollowers($favoriteId, $userId)
    {

        $favorite = Favorite::find($favoriteId);
        if(0 == $favorite->followed($userId)) {
            //关注收藏夹
            $favorite->users()->attach($userId);
            //关注数+1
            $this->addFollowsNum($favoriteId);

        } else {
            //取消关注收藏夹
            $favorite->users()->detach($userId);
            //关注数-1
            Favorite::where('id', $favoriteId)->decrement('followers_num');
        }
        return true;
    }

    /**
     * 从收藏夹添加--删除表情
     * @param $favoriteId
     * @param $memeId
     */
    public function saveToFavorite($favoriteId, $memeId)
    {
        $favorite = Favorite::find($favoriteId);

        if(0 == $favorite->hasThis($memeId)) {
            $favorite->memes()->attach($memeId);
            //表情数量+1
            $this->addMemesNum($favoriteId);

        } else {
            $favorite->memes()->detach($memeId);
            Favorite::where('id', $favoriteId)->decrement('memes_num');
        }
        return true;
    }

    /**
     * 关注数+1
     * @param $id
     */
    public function addFollowsNum($id)
    {
        Favorite::where('id', $id)->increment('followers_num');
    }

    /**
     * 表情数 + 1
     * @param $id
     */
    public function addMemesNum($id)
    {
        Favorite::where('id', $id)->increment('memes_num');
    }
}