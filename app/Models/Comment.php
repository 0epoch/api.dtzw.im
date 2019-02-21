<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    public function childComments()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function target()
    {
        return $this->hasOne(User::class, 'id', 'target_user_id');
    }

}
