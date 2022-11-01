<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Account;
use App\Difficulty;
use App\Chart;
use App\Genre;
use App\Post;
class AccountController extends Controller
{
    public function index(Chart $chart, Difficulty $difficulty, Genre $genre, Post $post)
    {
        $myposts = \App\Post::all()->where('user_id', Auth::user()->id)->pluck('chart_id')->toArray();
        return view('account.index')->with(['charts' => $chart->get(), 'difficulties' => $difficulty->get(), 'genres' => $genre->get(), 'posts' => $post -> orderBy('created_at', 'desc')->take(5)->get(), 'myposts'=>$myposts]);;
    }
    public function edit($id)
    {
        return view('account.edit');
    }
    public function update(AccountRequest $request, Account $account)
    {
        $account->fill($request->all());
    
        // パスワードの項目があるとき（つまり、パスワードを変更するとき）
        if (!is_null($request->password)) {
            // パスワードの値をハッシュ化して上書きする。
            $account->password = Hash::make($request->password);
        } else {
            // パスワードの項目に値がないときは、アップデートの対象にしない。
            unset($account->password);
        }
        $account->save();
        return redirect(route('account.index'));
    }
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        $query = Account::query();

        if(!empty($keyword)) {
            $query->where('name', 'LIKE', "%{$keyword}%");
        }

        $accounts = $query->orderBy('created_at','desc')->paginate(5);

        return view('account.search', compact('accounts', 'keyword'));
    }
    public function showAccountPage($id, Chart $chart, Difficulty $difficulty, Genre $genre, Post $post){
        $account = Account::find($id);
        $account_posts = \App\Post::all()->where('user_id', $id)->pluck('chart_id')->toArray();

        return view('account.showAccountPage')->with(['charts' => $chart->get(), 'difficulties' => $difficulty->get(), 'genres' => $genre->get(), 'posts' => $post -> orderBy('created_at', 'desc')->take(5)->get(), 'account_posts'=>$account_posts, 'account'=>$account]);
    }
}
