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
    public function index(Chart $chart, Difficulty $difficulty, Genre $genre, Follower $follower, Post $post)
    {

        
        $account = Auth::user();
        $myposts = \App\Post::all()->where('user_id', Auth::user()->id)->pluck('chart_id')->toArray();
        $news = \App\Post::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->take(5)->get();
        $login_user = auth()->user();
        $is_following = $login_user->isFollowing($account->id);
        $is_followed = $login_user->isFollowed($account->id);
        $follow_count = $follower->getFollowCount($account->id);
        $follower_count = $follower->getFollowerCount($account->id);
        $achieved_count = $post->getAchievedCount($account->id);
        $chart_count = $chart->count();
        $achieved_per = round(100 * ($achieved_count / $chart_count), 2);
        $chart_updated = \App\Chart::latest('updated_at')->pluck('updated_at')->first();
        return view('account.index')->with(['charts' => $chart->get(),
                                            'difficulties' => $difficulty->get(),
                                            'genres' => $genre->get(),
                                            'news' => $news,
                                            'account' => $account,
                                            'is_following'   => $is_following,
                                            'is_followed'    => $is_followed,
                                            'myposts' => $myposts,
                                            'follow_count' => $follow_count,
                                            'follower_count' => $follower_count,
                                            'achieved_count' => $achieved_count,
                                            'chart_count' => $chart_count,
                                            'achieved_per' => $achieved_per,
                                            'chart_updated' => $chart_updated
                                            ]);;
    }
    public function edit($id)
    {
        return view('account.edit');
    }
    public function update(AccountRequest $request, Account $account)
    {
        $account->fill($request->all());
    
        // ?????????????????????????????????????????????????????????????????????????????????????????????
        if (!is_null($request->password)) {
            // ???????????????????????????????????????????????????????????????
            $account->password = Hash::make($request->password);
        } else {
            // ?????????????????????????????????????????????????????????????????????????????????????????????
            unset($account->password);
        }
        $account->save();
        return redirect(route('account.index'));
    }
    
    public function searchInput(Request $request){
            //Request?????????????????????????????????
        $search_pref = $request->input('pref');
        $search_rank = $request->input('rank');
        $search_keyword = $request->input('keyword');

        //session()???????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????
        $old_pref = $request->session()->get("old_pref");
        $old_rank = $request->session()->get("old_rank");
        $old_keyword = $request->session()->get("old_keyword");

        //session()?????????????????????????????????forget()?????????
        $request->session()->forget(
        [
          'old_pref',
          'old_rank',
          'old_keyword',
        ]);

        //config????????????????????????????????????
        $prefs = config('pref');
        $ranks = config('rank');

        //view(search_input.blade.php)??????????????????
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

        //?????????????????????????????????Project????????????????????????$query?????????
        $query = Account::query();

        //Request?????????????????????????????????????????????????????????????????????

        //$search_work_locatio???????????????????????????????????????????????????????????????db???pref?????????$search_pref?????????????????????????????????
        if(!empty($search_keyword)) {
            $query->where('name', 'LIKE', "%{$search_keyword}%");
        }
        if (!is_null($search_pref) && $search_pref != 0) {
            $query->where('pref_id', $search_pref)->get();
        }
        if (!is_null($search_rank) && $search_rank != 0) {
            $query->where('rank_id', $search_rank)->get();
        }

        //1?????????5?????????????????????????????????????????????orderBy()???????????????project?????????????????????
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

        //view(search.blade.php)??????????????????
        $data = [
            "search_pref" => $search_pref,
            "search_rank" => $search_rank,
            "search_keyword" => $search_keyword,
            "accounts" => $accounts,
            "ranks" => $ranks,
            "prefs" => $prefs,
            "old_pref" => $old_pref,
            "old_rank" => $old_rank,
            "old_keyword" => $old_keyword,
        ];

        return view('account.search', $data);
    }

    public function showAccountPage($id, Chart $chart, Difficulty $difficulty, Genre $genre, Follower $follower, Post $post){
        $account = Account::find($id);
        $account_posts = \App\Post::all()->where('user_id', $id)->pluck('chart_id')->toArray();
        $news = \App\Post::where('user_id', $id)->orderBy('created_at', 'desc')->take(5)->get();
        $login_user = auth()->user();
        $is_following = $login_user->isFollowing($account->id);
        $is_followed = $login_user->isFollowed($account->id);
        $follow_count = $follower->getFollowCount($account->id);
        $follower_count = $follower->getFollowerCount($account->id);
        $achieved_count = $post->getAchievedCount($account->id);
        $chart_count = $chart->count();
        $achieved_per = round(100 * ($achieved_count / $chart_count), 2);
        $chart_updated = \App\Chart::latest('updated_at')->pluck('updated_at')->first();
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
                        'follower_count' => $follower_count,
                        'achieved_count' => $achieved_count,
                        'chart_count' => $chart_count,
                        'achieved_per' => $achieved_per,
                        'chart_updated' => $chart_updated
                        ]);
    }
    public function follow(Account $account)
    {
        $follower = auth()->user();
        // ???????????????????????????
        $is_following = $follower->isFollowing($account->id);
        if(!$is_following) {
            // ???????????????????????????????????????????????????
            $follower->follow($account->id);
            return back();
        }
    }
    
    public function unfollow(Account $account)
    {
        $follower = auth()->user();
        // ???????????????????????????
        $is_following = $follower->isFollowing($account->id);
        if($is_following) {
            // ??????????????????????????????????????????????????????
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
    public function test(Chart $chart, Difficulty $difficulty, Genre $genre, Follower $follower, Post $post){
        $account = Auth::user();
        $myposts = \App\Post::all()->where('user_id', Auth::user()->id)->pluck('chart_id')->toArray();
        $news = \App\Post::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->take(5)->get();
        $login_user = auth()->user();
        $is_following = $login_user->isFollowing($account->id);
        $is_followed = $login_user->isFollowed($account->id);
        $follow_count = $follower->getFollowCount($account->id);
        $follower_count = $follower->getFollowerCount($account->id);
        $achieved_count = $post->getAchievedCount($account->id);
        $chart_count = $chart->count();
        return view('account.test')->with(['charts' => $chart->get(),
                                            'difficulties' => $difficulty->get(),
                                            'genres' => $genre->get(),
                                            'news' => $news,
                                            'account' => $account,
                                            'is_following'   => $is_following,
                                            'is_followed'    => $is_followed,
                                            'myposts' => $myposts,
                                            'follow_count' => $follow_count,
                                            'follower_count' => $follower_count,
                                            'achieved_count' => $achieved_count,
                                            'chart_count' => $chart_count
                                            ]);;
    }
}
