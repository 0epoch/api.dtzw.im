<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Meme;
use App\Models\User;
use Illuminate\Http\Request;

class CommentsController extends BaseController
{
    use RepositoryTrait;


    public function index(Request $request)
    {
        $userId = $request->get('userId');
        $comments = Comment::where('user_id', $userId)->paginate(15);
        return $comments;
    }

    /**
     * 发表评论
     * @param Request $request
     */
    public function store(Request $request)
    {
        $attrs = $request->all();

        $comment = $this->commentRepository()->saveComment($attrs);
        return $this->success($comment);
    }

    public function comment(Request $request)
    {
        $meme_id = $request->get('meme_id');
        //评论，评论人，评论回复
        $comments = Comment::with(['user', 'childComments'])->where('meme_id', $meme_id)->where('parent_id', 0)->get();
        $comments = $comments->toArray();

        $childs = array_column($comments, 'child_comments');
        $users_id = [];
        $target_users_id = [];
        foreach ($childs as $row) {
            foreach ($row as $k => $v) {
                $users_id[] = $v['user_id'];
                $target_users_id[] = $v['target_user_id'];
            }
        }
        $id = array_merge($users_id, $target_users_id);
        $id = array_unique($id);

        $users = User::whereIn('id', $id)->get()->toArray();
        $users = array_combine(array_column($users, 'id'), $users);

        $comments = array_map(function($row) use($users) {
            $tmp = array_map(function($item) use($users) {
                $item['target_user'] = $users[$item['target_user_id']];
                $item['user'] = $users[$item['user_id']];
                return $item;
            }, $row['child_comments']);
            $row['child_comments'] = $tmp;
            return $row;
        }, $comments);

        //评论回复人,被回复人
        return $this->success($comments);
    }

    /**
     * 删除评论
     */
    public function delete()
    {

    }
}
