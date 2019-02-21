
<?php

namespace App\Repository;

use App\Models\Favorite;

class FavoriteRepository
{

    public function saveFavorite($attr)
    {
        $favorite = new Favorite();

        $favorite->name = $attr['name'];
        $favorite->user_id = $attr['userId'];
        $favorite->author = $attr['author'];
        $favorite->description = $attr['description'];
        $favorite->is_private = $attr['isPrivate'];
        $favorite->save();
    }

    public function saveFollowers($favoriteId, $userId)
    {
        $favorite = new Favorite();
        if(0==$favorite->followsThis($favoriteId)) {
            //关注收藏夹
            $favoriteUser = new FavoriteUser();
            $favoriteUser->user_id = $userId;
            $favoriteUser->favorite_id = $favoriteId;
            $favoriteUser->save();
            //关注数+1
            $this->addFollowsNum($favoriteId);

        } else {
            //取消关注收藏夹
            FavoriteUser::where('favorite_id', $favoriteId)->delete();
            //关注数-1
            Favorite::where('id', $favoriteId)->decrement('follows_num');
        }
        return true;
    }

    /**
     * 添加表情到收藏夹
     * @param $favoriteId
     * @param $stickerId
     */
    public function saveToFavorite($favoriteId, $stickerId)
    {
        $favorite = Favorite::find($favoriteId);
        if(0==$favorite->hasThis($stickerId)) {
            //删除收藏夹中表情
            FavoriteSticker::where('favorite_id', $favoriteId)->delete();
            Favorite::where('id', $favoriteId)->decrement('stickers_num');

        } else {
            $favoriteSticker = new FavoriteSticker();
            $favoriteSticker->favorite_id = $favoriteId;
            $favoriteSticker->sticker_id = $stickerId;
            $favoriteSticker->save();
            //表情数量+1
            $this->addStickersNum($favoriteId);
        }
        return true;
    }

    /**
     * 关注数+1
     * @param $id
     */
    public function addFollowsNum($id)
    {
        Favorite::where('id', $id)->increment('follows_num');
    }

    /**
     * 表情数 + 1
     * @param $id
     */
    public function addStickersNum($id)
    {
        Favorite::where('id', $id)->increment('stickers_num');
    }

    /**
     * 用户是否关注此收藏夹
     * @param $favoriteId
     * @param $userId
     */
    public function followed($favoriteId, $userId)
    {
        return FavoriteUser::where(['id' => $favoriteId, 'user_id' => $userId])->first();
    }

    /**
     * 是否拥有此表情
     * @param $sticker
     */
    public function hasThisSticker($stickerId, $favoriteId)
    {
        $favorite = Favorite::where('id', $favoriteId)->first();
    }
}