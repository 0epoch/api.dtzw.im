<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class MemeResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'author' => $this->author,
            'comments_num' => $this->comments_num,
            'votes_num' => $this->votes_num,
            'created_at' => $this->created_at->diffForHumans(),
            'paths' => $this->paths,
        ];
    }
}
