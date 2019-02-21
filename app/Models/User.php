<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $hidden = ['password', 'remember_token', 'updated_at'];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tag_user', 'user_id', 'tag_id');
    }

    public function votes()
    {
        return $this->belongsToMany(Vote::class, 'user_vote', 'user_id', 'meme_id');
    }

    public function favorites()
    {
        return $this->belongsToMany(Favorite::class, 'favorite_user', 'user_id', 'favorite_id');
    }

    /**
     * 用户关注/取消关注此标签
     * @param $id
     * @return array
     */
    public function followThisTag($id)
    {
        return $this->tags()->toggle($id);
    }

    /**
     * 用户点赞/取消点赞表情包
     * @param $memeId
     * @return array
     */
    public function voteFor($memeId)
    {
        return $this->votes()->toggle($memeId);
    }

    /**
     * 用户关注/取消关注此收藏夹
     * @param $id
     * @return array
     */
    public function followThisFavorite($id)
    {
        return $this->favorites()->toggle($id);
    }

}
