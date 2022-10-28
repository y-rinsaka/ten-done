<?php

namespace App\Http\Controllers;
use App\Post;
use App\Account;
use App\Chart;
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
    public function showPosts(Post $post, Account $account, Chart $chart){
         return view('posts.show')->with(['posts' => $post->get(), 'accounts' => $account->get(), 'charts' => $chart->get()]);
    }
    public function delete(Chart $chart, Account $account)
    {
        $delete_post = \App\Post::where('user_id', Auth::user()->id)->where('chart_id', $chart->id)->delete();
        return redirect('/');
    }
}
