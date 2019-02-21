<?php
/**
 * Created by PhpStorm.
 * User: gtianx
 * Date: 18-4-9
 * Time: 下午10:45
 */

namespace App\Repository;

use App\Models\Meme;
use App\Models\MemeTag;
use App\Models\MemePath;
use App\Models\Tag;

class MemeRepository
{

    public function findMemes()
    {
        $memes = Meme::with(['tags', 'paths'])->orderBy('id','DESC')->get();
        $list = [];
        foreach ($memes as $k => $meme) {
            if(count($meme->tags) > 0) {
                // dd($meme->tags);
                $memes[$k]['tags'] = $meme->tags;
            }

            if(count($meme->paths) > 0) {
                $memes[$k]['paths'] = $meme->paths;
            }
        }
        return $memes;
    }

    public function getMemeCommentsById($id)
    {
        $meme = Meme::with('comments')->where('id', $id)->first();
        return $meme->commets;
    }

    public function saveMemes($attr)
    {
        $user = auth('api')->user();

        $meme = new Meme();
        $meme->description = $attr['description'];
        $meme->user_id = $user->id;
        $meme->author = $user->name;
        $meme->save();

        $paths = [];
        foreach ($attr['paths'] as $path) {
            $paths[]['path'] = $path;
        }
        //一对多保存表情包路径
        $meme->paths()->createMany($paths);
        //多对多关联 自动写入关联表数据
        $meme->tags()->attach(explode(',', $attr['tagsId']));

        //tags表memes_num 计数
        Tag::whereIn('id', explode(',', $attr['tagsId']))->increment('memes_num', count($attr['paths']));
        return $meme;
    }

    public function removeMeme($id)
    {
        Meme::destroy($id);
        //删除标签关联
        memeUrl::where('meme_id', $id)->delete();
        //删除url关联
        memeTag::where('meme_id', $id)->delete();
    }

    /**
     * 增加表情包评论数
     */
    public function addCommentsNum($id)
    {
        Meme::where('id', $id)->increment('comments_num');
        return true;
    }
}