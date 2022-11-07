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
        $news = \App\Post::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->take(5)->get();
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
    public function showAccountPage($id, Chart $chart, Difficulty $difficulty, Genre $genre, Follower $follower){
        $account = Account::find($id);
        $account_posts = \App\Post::all()->where('user_id', $id)->pluck('chart_id')->toArray();
        $news = \App\Post::where('user_id', $id)->orderBy('created_at', 'desc')->take(5)->get();
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
