<?php

namespace App\Http\Controllers;
use App\Post;
use App\Account;
use App\Chart;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $input_post = $request['post'];
        $post->fill($input_post)->save();
        return redirect('/');
    }
    public function showPosts(Post $post, Account $account, Chart $chart){
         return view('posts.show')->with(['posts' => $post->get(), 'accounts' => $account->get(), 'charts' => $chart->get()]);
    }
}
