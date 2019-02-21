<?php
/**
 * Created by PhpStorm.
 * User: 0EPOCH
 * Date: 2018/5/6
 * Time: 18:33
 */

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Meme;

class VotesController extends BaseController
{
    use RepositoryTrait;

    public function isVoted($id)
    {

    }

    /**
     * 用户点赞表情
     * @return \Illuminate\Http\JsonResponse
     */
    public function vote()
    {
        $user = auth('api')->user();

        $meme_id = request('meme_id');
        $voted = $user->voteFor($meme_id);

        if(count($voted['attached']) > 0) {
            Meme::where('id', $meme_id)->increment('votes_num');

            return response()->json(['voted' => true]);
        } else {
            Meme::where('id', $meme_id)->decrement('votes_num');
            return response()->json(['voted' => false]);
        }
    }
}