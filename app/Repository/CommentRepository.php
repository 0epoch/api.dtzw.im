<?php

namespace App\Repository;

use App\Models\Comment;
use App\Models\Meme;

class CommentRepository
{


    public function saveComment($data)
    {
        $user = auth('api')->user();
        $comment = new Comment();
        if(isset($data['comment_id'])) {
            $result = Comment::where('id', $data['comment_id'])->firstOrFail();
            $comment->target_user_id = $result->user_id;
            $comment->parent_id = $data['parent_id'];
        }

        $comment->user_id = $user->id;
        $comment->meme_id = $data['meme_id'];
        $comment->content = $data['content'];

        $comment->save();
        //更新meme表当前meme评论总数
        Meme::where('id', $data['meme_id'])->increment('comments_num');
        return $comment;
    }

}