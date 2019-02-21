<?php
/**
 * Created by PhpStorm.
 * User: gtianx
 * Date: 18-4-18
 * Time: 下午10:21
 */

namespace App\Repository;

use App\Models\Comment;

class CommentRepository
{


    public function saveComment($attributes)
    {
        $comment = new Comment();
        $comment->user_id = $attributes['userId'];
        $comment->author = $attributes['author'];
        $comment->sticker_id = $attributes['sticker_id'];
        $comment->body = $attributes['body'];
        $comment->is_block = 'F';
        $comment->save();
        //更新sticker表当前sticker评论总数
    }
}