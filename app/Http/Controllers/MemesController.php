<?php
/**
 * Created by PhpStorm.
 * User: gtianx
 * Date: 18-4-9
 * Time: 下午10:46
 */

namespace App\Http\Controllers;

use App\Http\Resources\MemeResource;
use Illuminate\Http\Request;
use App\Models\Meme;

class MemesController extends BaseController
{
    use RepositoryTrait;
    public function index()
    {
        return MemeResource::collection(Meme::paginate());
    }

    public function create(Request $request)
    {
        $attributes = request()->all();
        $path = [];
        $memes  = $request->file('files');
        foreach ($memes as $meme) {
            $path[] = $meme->store('memes');
        }

        $attributes['paths'] = $path;

        $meme = $this->memeRepository()->saveMemes($attributes);
        return $this->success($meme);
    }

    public function remove($id)
    {
        //根据主键直接删除
        Meme::destroy($id);
        $this->memeRepository()->removeMeme($id);
        return response()->json(['msg'=>'ok']);
    }

    /**
     * 点赞
     * @param $memeId
     * @return mixed
     */
    public function vote($memeId)
    {
        $user = auth('api')->user();
        $result = $user->voteFor($memeId);
        if([] === $result['attached']) {
            $attached = -1;
            Meme::where('id', $memeId)->decrement('votes_num');
        } else {
            $attached = 1;
            Meme::where('id', $memeId)->increment('votes_num');
        }
        return $this->success($attached);
    }
}