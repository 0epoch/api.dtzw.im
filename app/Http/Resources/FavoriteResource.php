<?php
/**
 * Created by PhpStorm.
 * User: 0EPOCH
 * Date: 2018/7/28
 * Time: 11:29
 */

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\Resource;

class FavoriteResource extends Resource
{
    public function toArray($request)
    {
        $meme_id = $request->get('meme_id');
        return [
            'id' => $this->id,
            'name' => $this->name,
            'author' => $this->author,
            'memes_num' => $this->memes_num,
            'has_this' => $this->hasThis($meme_id),
            'created_at' => $this->created_at->diffForHumans(),
        ];
    }
}