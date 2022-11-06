@extends('layouts.app')
@section('content')
@if(!empty($account))
    <div class="profile_posts">
        <div>
            <div>
                @if (auth()->user()->isFollowing($account->id))
                    <form action="{{ route('unfollow', $account->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">フォロー解除</button>
                    </form>
                @else
                    <form action="{{ route('follow', $account->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">フォローする</button>
                    </form>
                @endif
            </div>
            @if (auth()->user()->isFollowed($account->id))
                <div class="px-2">
                    <span class="px-1 bg-secondary text-light">フォローされています</span>
                </div>
            @endif
            <table border="1" id="profile_table">
                <tr><td rowspan="2"><img src="https://img.taiko-p.jp/imgsrc.php?v=&kind=mydon&fn=mydon_{{$account->taiko_id}}" class="mydon_image"/></td><th>プレイヤー名</th><td>{{$account->name}}</td><th>都道府県</th><td>{{App\Account::$prefs[$account->pref_id]}}</td></tr>
                <tr><th>太鼓番</th><td>{{$account->taiko_id}}</td><th>現在の段位</th><td>{{App\Account::$ranks[$account->rank_id]}}</td></tr>
            </table>
            <a href="https://donderhiroba.jp/user_profile.php?taiko_no={{$account->taiko_id}}">ドンだーひろば</a>


        </div>
        <div>
            <h2>ニュース</h2>
            <ul>
                @if (count($news) == 0)
                    <br/>
                    <h3>ニュースはありません</h3>
                @else
                    @foreach ($news as $post)
                        <li>{{ $post->chart->name }} ドンダフルコンボ！({{$post->created_at->format('Y/m/d')}})</li>
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
    <div class="content_charts">
        <hr/>
        <h1 class=>☆10全良難易度表</h1>
        
        <table id="charts_table">
            @foreach ($difficulties as $difficulty)
                <tr>
                    <th>{{ $difficulty->name }}</th>
                @foreach ($charts as $chart)
                    
                    @if ($chart->difficulty->name === $difficulty->name)
                        @if (in_array($chart->id, $account_posts))
                            <td class="chart_{{ $chart->id }}" bgcolor="#ffd700">{{ $chart->name }}</td>
                        @else
                            <td class="chart_{{ $chart->id }}">{{ $chart->name }}</td>
                        @endif
                    @endif
                @endforeach
                </tr>
            @endforeach
        </table>
    </div>
@endif
@endsection