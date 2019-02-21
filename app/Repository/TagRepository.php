<?php
/**
 * Created by PhpStorm.
 * User: gtianx
 * Date: 18-4-8
 * Time: 下午9:57
 */

namespace App\Repository;

use App\Models\Tag;

class TagRepository
{

    public function findTags()
    {
        return Tag::all();
    }

    public function saveTag(array $data)
    {
        $tag = new Tag();
        $tag->name = $data['name'];
        $tag->describe = $data['describe'];
        $tag->save();
        return $tag;
    }

    public function setFollowers($id, $userId)
    {
        Tag::where('id', $id)->update('followers', $userId);
        return ture;
    }

    public function addStickersNum($id)
    {
        Tag::where('id', $id)->increment('stickers_num');
        return ture;
    }

    public function addFollowNum()
    {
        Tag::where('id', $id)->increment('follows_num');
        return ture;
    }
}