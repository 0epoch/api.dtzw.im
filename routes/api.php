<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//注册登录
Route::group(['prifx' => 'auth'], function($router) {
    Route::post('/signup', 'AuthController@signup');
    Route::post('/login', 'AuthController@login');
    Route::post('/logout', 'AuthController@logout');
    Route::post('/refresh', 'AuthController@refresh');
});

Route::prefix('user')->group(function($router) {
    Route::get('/{uid}/favorites', 'UserController@favorites');
});

//标签
Route::get('/tags', 'TagsController@index');
Route::get('tags/memes', 'TagsController@memes');
Route::post('/tags', 'TagsController@create');
Route::get('/tags/follow', 'TagsController@follow');
Route::get('/tags/{keyword}', 'TagsController@show');

//表情包
Route::get('/memes', 'MemesController@index'); //列表
Route::post('/memes', 'MemesController@create');// 发布
Route::delete('/memes/{id}', 'MemesController@remove'); //删除

//收藏夹
Route::post('/favorite', 'FavoritesController@create'); //创建收藏夹
Route::put('/favorite', 'FavoritesController@toggle'); //添加加表情到收藏夹
Route::post('favorite/follows', 'FavoritesController@followsThisFavorite'); //关注收藏夹
Route::get('/favorite/u/{uid}/favorites', 'FavoritesController@userFavorites'); //用户收藏夹列表

//评论
Route::post('/comments', 'CommentsController@store'); //发布评论
Route::get('/comments', 'CommentsController@comment'); //表情评论


//点赞
Route::put('/votes', 'VotesController@vote'); //点赞表情

//个人中心
//TODO 我发布的表情列表， 我发布的评论列表， 我的收藏夹列表，动态（我点赞的，点赞我的， 回复我的评论）