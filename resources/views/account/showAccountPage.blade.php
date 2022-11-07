@extends('layouts.app')
@section('content')
@if(!empty($account))
    <div class="profile_posts">
        <div>
            <table border="1" id="profile_table">
                <tr><td rowspan="2"><img src="https://img.taiko-p.jp/imgsrc.php?v=&kind=mydon&fn=mydon_{{$account->taiko_id}}" class="mydon_image"/></td><th>プレイヤー名</th><td>{{$account->name}}</td><th>都道府県</th><td>{{App\Account::$prefs[$account->pref_id]}}</td></tr>
                <tr><th>太鼓番</th><td>{{$account->taiko_id}}</td><th>現在の段位</th><td>{{App\Account::$ranks[$account->rank_id]}}</td></tr>
            </table>
            <a href="https://donderhiroba.jp/user_profile.php?taiko_no={{$account->taiko_id}}">ドンだーひろば</a>
            <div class="d-flex justify-content-start">
                <div class="p-2 d-flex flex-column align-items-center">
                    <p class="font-weight-bold">フォロー数</p>
                    <span>{{ $follow_count }}</span>
                </div>
                <div class="p-2 d-flex flex-column align-items-center">
                    <p class="font-weight-bold">フォロワー数</p>
                    <span>{{ $follower_count }}</span>
                </div>
            </div>
                @if ($account->id === Auth::user()->id)
                    <a href="{{ url('account/' .$account->id .'/edit') }}" class="btn btn-primary">プロフィールを編集</a>
                    <a href="/" class="btn btn-primary">マイページに戻る</a>
                @else
                    @if ($is_following)
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
                    @if ($is_followed)
                        <div class="px-2">
                            <span class="px-1 bg-secondary text-light">フォローされています</span>
                        </div>
                    @endif
                @endif
        </div>
        <div>
            <h2>ニュース</h2>
            <ul>
                @if (count($news) == 0)
                    <br/>
                    <h3>ニュースはありません</h3>
                @else
                    @foreach ($news as $post)
                        <li>
                            {{ $post->chart->name }} ドンダフルコンボ！({{$post->created_at->format('Y/m/d')}})
                            <div class="d-flex align-items-center">
                                @if (!in_array(Auth::user()->id, array_column($post->favorites->toArray(), 'user_id'), TRUE))
                                    <form method="POST" action="{{ url('favorites/') }}" class="mb-0">
                                        @csrf
                
                                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                                        <button type="submit" class="btn p-0 border-0 text-primary"><i class="far fa-heart fa-fw"></i></button>
                                    </form>
                                @else
                                    <form method="POST"action="{{ url('favorites/' .array_column($post->favorites->toArray(), 'id', 'user_id')[Auth::user()->id]) }}" class="mb-0">
                                        @csrf
                                        @method('DELETE')
                
                                        <button type="submit" class="btn p-0 border-0 text-danger"><i class="fas fa-heart fa-fw"></i></button>
                                    </form>
                                @endif
                                <p class="mb-0 text-secondary">{{ count($post->favorites) }}</p>
                            </div>
                        </li>
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