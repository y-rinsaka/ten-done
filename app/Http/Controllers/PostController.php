<?php

namespace App\Http\Controllers;
use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function news(Post $post)
    {
        return view('posts/news')->with(['posts' => $post->getPaginateByLimit()]);
    }
}
