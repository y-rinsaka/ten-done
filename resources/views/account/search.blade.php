@extends('layouts.app')
@section('content')
    <h2>ユーザ検索</h2>
    <div class="search_form">
        <form action="{{ route('account.search') }}" method="GET" class="form-inline">
            <div class="form-group">
                <label>プレイヤー名</label>
                <input type="text" class="form-control col-md-5" name="keyword" placeholder="どんちゃん" value="{{ $keyword }}">
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
            </tr>
        
        @forelse ($accounts as $account)
            <tr>
                <td><img src="https://img.taiko-p.jp/imgsrc.php?v=&kind=mydon&fn=mydon_{{ $account->taiko_id }}" class="mydon_image_at_search" /></td>
                <td>{{ $account->name }}</td>
                <td>{{ App\Account::$ranks[$account->rank_id] }}</td>
                <td>{{ App\Account::$prefs[$account->pref_id] }}</td>
            </tr>
            @empty
            <td>見つかりませんでした</td>
        @endforelse
        
        </table>
        {{ $accounts->appends(request()->input())->render('pagination::bootstrap-4') }}
    </div>
@endsection