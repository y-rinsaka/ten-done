<?php

namespace App\Http\Controllers;
use App\Post;
use App\Account;
use App\Chart;
use App\Follower;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $input_post = $request['post'];
        $post->fill($input_post)->save();
        return redirect('/');
    }
    public function showPosts(Chart $chart, Follower $follower){
        
        $posts = \App\Post::query()->whereIn('user_id', Auth::user()->follows()->pluck('followed_id'))->latest()->paginate(10);
        return view('posts.show', compact('posts'));
    }
    public function delete(Chart $chart, Account $account)
    {
        $delete_post = \App\Post::where('user_id', Auth::user()->id)->where('chart_id', $chart->id)->delete();
        return redirect('/');
    }
}
