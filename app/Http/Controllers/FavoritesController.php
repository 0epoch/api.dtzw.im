<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    use RepositoryTrait;

    public function index()
    {

    }

    public function create()
    {

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
    public  function followsThisFavorite(Request $request)
    {
        $id = $request->get('id');
        $userId = $request->get('userId');
        $this->fovariteRepository()->saveFollowers($id, $userId);

        return response()->json('成功');
    }

    /**
     * 添加表情到收藏夹(从收藏夹删除表情)
     * @param Request $request
     */
    public function comeAndGoFavorite(Request $request)
    {
        $stickerId = $request->get('stickerId');
        $favoriteId = $request->get('favoriteId');

        //添加到
        $favorite = Favorite::where('id', $favoriteId)->first();

        //删除掉

        $this->favoriteRepository()->saveAddTo($favoriteId, $stickerId);
    }
}
