<?php
/**
 * Created by PhpStorm.
 * User: gtianx
 * Date: 18-4-8
 * Time: 下午10:18
 */

namespace App\Http\Controllers;


trait RepositoryTrait
{

    public function userRepository()
    {
        $repository = new \App\User();
        return $repository;
    }

    public function tagRepository()
    {
        $repository = new \App\Repository\TagRepository();
        return $repository;
    }

    public function memeRepository()
    {
        $repository = new \App\Repository\memeRepository();
        return $repository;
    }

    public function commentRepository()
    {
        $repository = new \App\Repository\CommentRepository();
        return $repository;
    }

    public function favoriteRepository()
    {
        $repository = new \App\Repository\FavoriteRepository();
        return $repository;
    }
}