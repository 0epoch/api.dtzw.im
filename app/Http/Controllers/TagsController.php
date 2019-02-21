<?php

namespace App\Http\Controllers;

use App\Models\Meme;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Console\PackageDiscoverCommand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagsController extends BaseController
{
    use RepositoryTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tags = $this->tagRepository()->findTags();
        return response()->json($tags);
    }

    public function memes(Request $request)
    {
        $id = $request->get('id');
        $memes = DB::table('meme_tag as t')
            ->leftJoin('meme_paths as p', 't.meme_id', '=', 'p.meme_id')
            ->where('t.tag_id', $id)
            ->select('p.*')
            ->get();

        return response()->json($memes);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $attributes = $request->only('data');
        // dd($attributes);
        $thumb  = $request->file('files')[0];
        $thumb_path = $thumb->store('uploads', 'memes');
        $attributes['thumb_path'] = $thumb_path;
//        $attributes = ['name' => '问题在哪里', 'describe' => '问题描述在哪里'];
        $tag = $this->tagRepository()->saveTag($attributes);
        return $tag;
    }


    /**
     * 关注标签
     */
    public function follow()
    {
        $id = request('id');
        $userId = request('userId');

        $user = User::find($userId);
        $followed = $user->followThisTag($id);

        if(count($followed['attached']) > 0) {
            Tag::where('id', $id)->increment('followers_num');

        } else  {
            Tag::where('id', $id)->decrement('followers_num');
        }

    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Tags  $tags
     * @return \Illuminate\Http\Response
     */
    public function show($keyword)
    {
        $tag = Tag::where('name', 'like', '%'.$keyword.'%')->get();
        return $this->success($tag);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tags  $tags
     * @return \Illuminate\Http\Response
     */
    public function edit(Tags $tags)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tags  $tags
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tags $tags)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tags  $tags
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tags $tags)
    {
        //
    }
}
