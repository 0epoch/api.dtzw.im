<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function favorites()
    {
        $this->belongsToMany(Favorite::class, 'favorite_user', 'user_id', 'favorite_id')->withTimestamps();
    }

    public function tags()
    {
        $this->belongsToMany(Tag::class, 'tag_user', 'user_id', 'tag_id')->withTimestamps();
    }
    /**
     * 是否关注收藏夹
     */
    public function followedFavorite($favoriteId)
    {
        return $this->favorites()->where('favorite_id', $favoriteId)->count();
    }

    /**
     * 是否关注标签
     */
    public function followedTag($tagId)
    {
        return $this->tags()->where('tag_id', $tagId)->count();
    }
}
