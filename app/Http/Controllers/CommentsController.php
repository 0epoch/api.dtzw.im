<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommentsController extends Controller
{
    //
    public function index()
    {

    }

    public function create(Request $request)
    {
        $attributes = $request->all();
        $this->commentRepository()->saveComment($attributes);
    }
}
