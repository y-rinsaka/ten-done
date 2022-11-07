@extends('layouts.app')
@section('content')
<a href="/search" class="btn btn-primary">ユーザを検索する</a>
<div class="tab-wrap">
    <input id="TAB-01" type="radio" name="TAB" class="tab-switch" checked="checked" /><label class="tab-label" for="TAB-01">フォロー中</label>
    <div class="tab-content">
        <table class="table">
            <tr>
                <th></th>
                <th>プレイヤー名</th>
                <th>現在の段位</th>
                <th>都道府県</th>
                <td>フォロー</td>
            </tr>
        
        @forelse ($follow_accounts as $account)
            <tr>
                <td><img src="https://img.taiko-p.jp/imgsrc.php?v=&kind=mydon&fn=mydon_{{ $account->taiko_id }}" class="mydon_image_at_search" /></td>
                <td><a href="/account/{{ $account->id }}">{{ $account->name }}</a>
                    <p>
                        @if (auth()->user()->isFollowed($account->id))
                            <div class="px-2">
                                <span class="px-1 bg-secondary text-light">フォローされています</span>
                            </div>
                        @endif
                    </p>
                </td>
                <td>{{ App\Account::$ranks[$account->rank_id] }}</td>
                <td>{{ App\Account::$prefs[$account->pref_id] }}</td>
                <td>
                    @if ($account->id === Auth::user()->id)
                    
                    @else
                        @if (auth()->user()->isFollowing($account->id))
                            <form action="{{ route('unfollow', $account->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-primary">フォロー中</button>
                            </form>
                        @else
                            <form action="{{ route('follow', $account->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary">フォローする</button>
                            </form>
                        @endif
                    @endif
                </td>
            </tr>
            @empty
            <td>見つかりませんでした</td>
        @endforelse
        </table>
    </div>
    <input id="TAB-02" type="radio" name="TAB" class="tab-switch" /><label class="tab-label" for="TAB-02">フォロワー</label>
    <div class="tab-content">
            <table class="table">
            <tr>
                <th></th>
                <th>プレイヤー名</th>
                <th>現在の段位</th>
                <th>都道府県</th>
                <td>フォロー</td>
            </tr>
        
        @forelse ($follower_accounts as $account)
            <tr>
                <td><img src="https://img.taiko-p.jp/imgsrc.php?v=&kind=mydon&fn=mydon_{{ $account->taiko_id }}" class="mydon_image_at_search" /></td>
                <td><a href="/account/{{ $account->id }}">{{ $account->name }}</a>
                    <p>
                        @if (auth()->user()->isFollowed($account->id))
                            <div class="px-2">
                                <span class="px-1 bg-secondary text-light">フォローされています</span>
                            </div>
                        @endif
                    </p>
                </td>
                <td>{{ App\Account::$ranks[$account->rank_id] }}</td>
                <td>{{ App\Account::$prefs[$account->pref_id] }}</td>
                <td>
                    @if ($account->id === Auth::user()->id)
                    
                    @else
                        @if (auth()->user()->isFollowing($account->id))
                            <form action="{{ route('unfollow', $account->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-primary">フォロー中</button>
                            </form>
                        @else
                            <form action="{{ route('follow', $account->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary">フォローする</button>
                            </form>
                        @endif
                    @endif
                </td>
            </tr>
            @empty
            <td>見つかりませんでした</td>
        @endforelse
        </table>
    </div>
</div>
@endsection