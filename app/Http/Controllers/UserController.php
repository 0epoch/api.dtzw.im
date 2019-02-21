<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Http\Resources\FavoriteResource;

class UserController extends BaseController
{
    //
    public function index()
    {

    }

    /**
     * 用户收藏夹
     */
    public function favorites(int $uid)
    {
        $favorites = Favorite::where('user_id', $uid)->get();
        return FavoriteResource::collection($favorites);
    }

    //评论列表
    public function comments()
    {

    }

    /**
     * 动态
     */
    public function trends()
    {

    }


}
