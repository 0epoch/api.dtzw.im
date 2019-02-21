<?php

namespace App\Http\Controllers;

use App\Http\Resources\FavoriteResource;
use App\Models\Favorite;
use App\Models\User;
use Illuminate\Http\Request;

class FavoritesController extends BaseController
{
    use RepositoryTrait;

    public function index()
    {

    }

    public function create(Request $request)
    {
        $favorite = $this->favoriteRepository()->saveFavorite($request->all());
        return $this->success($favorite);
    }

    /**
     * 用户是否关注了此收藏夹
     */
    public function isFollows(Request $request)
    {
        //TODO 获取用户
        $userId = 1;
        $favoriteId = $request->get('favoriteId');
        $followed = $this->favoriteRepository()->followed($favoriteId, $userId);
        if($followed) {
            return response()->json(['ok']);
        }
        return response()->json('no');
    }

    /**
     * 用户关注表情包(收藏夹)
     * @param Request $request
     */
    public  function follows(Request $request)
    {
        $id = $request->get('id');
        $userId = $request->get('userId');

        $user = User::find($userId);

        $followed = $user->followThisFavorite($id);
        if(count($followed['attached']) > 0) {
            Favorite::where('id', $id)->increment('followers_num');

        } else {
            Favorite::where('id', $id)->decrement('followers_num');
        }
        return response()->json('成功');
    }

    /**
     * 添加表情到收藏夹(从收藏夹删除表情)
     * @param Request $request
     */
    public function toggle(Request $request)
    {
        $meme_id = $request->get('meme_id');
        $favorite_id = $request->get('favorite_id');
        $result = $this->favoriteRepository()->saveToFavorite($favorite_id, $meme_id);
        return $this->success($result);
    }

    /**
     * 删除收藏夹
     */
    public function delete(Request $request)
    {
        //删除收藏夹
        $favoriteId = $request->get('favoriteId');
        Favorite::where('id', $favoriteId)->update('is_remove', 'T');
    }
}
