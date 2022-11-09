@extends('layouts.app')
@section('content')
    <h2>ユーザ検索</h2>
    <div class="search_form">
        <form action="{{ route('account.search') }}" method="GET" class="form-inline">
            <div class="form-group">
                <div class="font-weight-bold"><label>プレイヤー名</label></div>
                <input type="text" class="form-control col-md-3" name="keyword" placeholder="どんちゃん" value="{{ $keyword }}">
                <div class="font-weight-bold"><label for="pref_id">都道府県</label></div>
                <select class="form-control" name="pref_id">
                    @foreach($prefs as $key => $pref)
                        <option value="{{ $key }}">
                            {{ $pref }}
                        </option>
                    @endforeach
                </select>
                <div class="font-weight-bold"><label for="rank_id">現在の段位</label></div>
                <select class="form-control" name="rank_id">
                    @foreach($ranks as $key => $rank)
                        <option value="{{ $key }}">
                            {{ $rank }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">検索</button>
        </form>
    </div>
    
    <div class="content_search">
        <table class="table">
            <tr>
                <th></th>
                <th>プレイヤー名</th>
                <th>現在の段位</th>
                <th>都道府県</th>
                <td>フォロー</td>
            </tr>
        
        @forelse ($accounts as $account)
            <tr>
                <td><a href="/account/{{$account->id}}"><img src="https://img.taiko-p.jp/imgsrc.php?v=&kind=mydon&fn=mydon_{{ $account->taiko_id }}" class="mydon_image_at_search" /></a></td>
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
        {{ $accounts->appends(request()->input())->render('pagination::bootstrap-4') }}
    </div>
@endsection