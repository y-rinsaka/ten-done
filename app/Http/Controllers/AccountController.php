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
use App\Follower;
class AccountController extends Controller
{
    public function index(Chart $chart, Difficulty $difficulty, Genre $genre, Follower $follower)
    {

        
        $account = Auth::user();
        $myposts = \App\Post::all()->where('user_id', Auth::user()->id)->pluck('chart_id')->toArray();
        $news = \App\Post::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->take(3)->get();
        $login_user = auth()->user();
        $is_following = $login_user->isFollowing($account->id);
        $is_followed = $login_user->isFollowed($account->id);
        $follow_count = $follower->getFollowCount($account->id);
        $follower_count = $follower->getFollowerCount($account->id);
        return view('account.index')->with(['charts' => $chart->get(),
                                            'difficulties' => $difficulty->get(),
                                            'genres' => $genre->get(),
                                            'news' => $news,
                                            'account' => $account,
                                            'is_following'   => $is_following,
                                            'is_followed'    => $is_followed,
                                            'myposts' => $myposts,
                                            'follow_count' => $follow_count,
                                            'follower_count' => $follower_count
                                            ]);;
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
    
    public function searchInput(Request $request){
            //Requestで送られてきた値を代入
        $search_pref = $request->input('pref');
        $search_rank = $request->input('rank');
        $search_keyword = $request->input('keyword');

        //session()を使用し検索条件を一時的に保存し代入（検索結果画面から検索画面に戻った時の値の保持が目的）
        $old_pref = $request->session()->get("old_pref");
        $old_rank = $request->session()->get("old_rank");
        $old_keyword = $request->session()->get("old_keyword");

        //session()で一時的に保存した値をforget()で削除
        $request->session()->forget(
        [
          'old_pref',
          'old_rank',
          'old_keyword',
        ]);

        //configから各項目をそれぞれ代入
        $prefs = config('pref');
        $ranks = config('rank');

        //view(search_input.blade.php)に変数を渡す
        $data = [
            "search_keyword" => $search_keyword,
            "ranks" => $ranks,
            "prefs" => $prefs,
            "old_rank" => $old_rank,
            "old_pref" => $old_pref, 
            "old_keyword" => $old_keyword,
        ];

        return view('account.searchInput', $data);
    }
    
    public function search(Request $request)
    {
        $search_pref = $request->input('pref');
        $search_rank = $request->input('rank');
        $search_keyword = $request->input('keyword');

        //クエリビルダを使用し、Projectテーブルの中身を$queryに代入
        $query = Account::query();

        //Requestで値が送られてきた場合の検索条件をそれぞれ記述

        //$search_work_locatioに値があり、かつ　０（未選択）でない場合、dbのpref　と　$search_pref　が一致していれば取得
        if(!empty($search_keyword)) {
            $query->where('name', 'LIKE', "%{$search_keyword}%");
        }
        if (!is_null($search_pref) && $search_pref != 0) {
            $query->where('pref_id', $search_pref)->get();
        }
        if (!is_null($search_rank) && $search_rank != 0) {
            $query->where('rank_id', $search_rank)->get();
        }

        //1ページ5件でページネーションを追加　（orderBy()を使用し、projectを昇順で表示）
        $accounts = $query->orderBy('updated_at', 'desc')->get();

        $ranks = config('rank');
        $prefs = config('pref');

        $request->session()->put("old_pref", $search_pref);
        $request->session()->put("old_rank", $search_rank);
        $request->session()->put("old_keyword", $search_keyword);

        $old_pref = $request->session()->get("old_pref");
        $old_rank = $request->session()->get("old_rank");
        $old_keyword = $request->session()->get("old_keyword");

        if ($request->get('back')){
            return redirect('/searchInput')->withInput([ 
                $old_pref, 
                $old_rank, 
                $old_keyword,
            ]);
        }

        //view(search.blade.php)に変数を渡す
        $data = [
            "search_pref" => $search_pref,
            "search_rank" => $search_rank,
            "search_keyword" => $search_keyword,
            "accounts" => $accounts,
            "search_keyword" => $search_keyword,
            "ranks" => $ranks,
            "prefs" => $prefs,
            "old_pref" => $old_pref,
            "old_rank" => $old_rank,
            "old_keyword" => $old_keyword,
        ];

        return view('account.search', $data);
    }

    public function showAccountPage($id, Chart $chart, Difficulty $difficulty, Genre $genre, Follower $follower){
        $account = Account::find($id);
        $account_posts = \App\Post::all()->where('user_id', $id)->pluck('chart_id')->toArray();
        $news = \App\Post::where('user_id', $id)->orderBy('created_at', 'desc')->take(3)->get();
        $login_user = auth()->user();
        $is_following = $login_user->isFollowing($account->id);
        $is_followed = $login_user->isFollowed($account->id);
        $follow_count = $follower->getFollowCount($account->id);
        $follower_count = $follower->getFollowerCount($account->id);
        return view('account.showAccountPage')
                ->with(['charts' => $chart->get(),
                        'difficulties' => $difficulty->get(),
                        'genres' => $genre->get(),
                        'news' =>$news,
                        'account_posts'=>$account_posts,
                        'account'=>$account,
                        'is_following'   => $is_following,
                        'is_followed'    => $is_followed,
                        'follow_count'   => $follow_count,
                        'follower_count' => $follower_count
                        ]);
    }
    public function follow(Account $account)
    {
        $follower = auth()->user();
        // フォローしているか
        $is_following = $follower->isFollowing($account->id);
        if(!$is_following) {
            // フォローしていなければフォローする
            $follower->follow($account->id);
            return back();
        }
    }
    
    public function unfollow(Account $account)
    {
        $follower = auth()->user();
        // フォローしているか
        $is_following = $follower->isFollowing($account->id);
        if($is_following) {
            // フォローしていればフォローを解除する
            $follower->unfollow($account->id);
            return back();
        }
    }
    public function showFollowAndFollower(Account $account){
        $follower_account_id = \App\Follower::where('followed_id', Auth::user()->id)->pluck('following_id')->toArray();
        $follow_account_id = \App\Follower::where('following_id', Auth::user()->id)->pluck('followed_id')->toArray();
        
        $follower_accounts = \App\Account::whereIn('id', $follower_account_id)->get();
        $follow_accounts = \App\Account::whereIn('id', $follow_account_id)->get();
        
        return view('account.showFollowAndFollower')->with(['follow_accounts'=>$follow_accounts,
                                                            'follower_accounts'=>$follower_accounts
                                                            ]);
    }
}
