@extends('layouts.app')
@section('content')
    <div>
        <div class="col-md-4">
            <table border="1" id="profile_tables">
                <tr><td rowspan="2"><img src="https://img.taiko-p.jp/imgsrc.php?v=&kind=mydon&fn=mydon_{{Auth::user()->taiko_id}}" class="mydon_image"/></td><th>プレイヤー名</th><td>{{Auth::user()->name}}</td><th>都道府県</th><td>{{App\Account::$prefs[Auth::user()->pref_id]}}</td></tr>
                <tr><th>太鼓番</th><td>{{Auth::user()->taiko_id}}</td><th>現在の段位</th><td>{{App\Account::$ranks[Auth::user()->rank_id]}}</td></tr>
            </table>
            <a href="https://donderhiroba.jp/user_profile.php?taiko_no={{Auth::user()->taiko_id}}">ドンだーひろば</a>
            <div class="d-flex justify-content-start">
                <div class="p-2 d-flex flex-column align-items-center">
                    <p class="font-weight-bold">フォロー数</p>
                    <a href="/follow_follower">{{ $follow_count }}</a>
                </div>
                <div class="p-2 d-flex flex-column align-items-center">
                    <p class="font-weight-bold">フォロワー数</p>
                    <a href="/follow_follower">{{ $follower_count }}</a>
                </div>
            </div>
            <a href="{{ url('account/' .$account->id .'/edit') }}" class="btn btn-primary">プロフィールを編集</a>
        </div>
        <div class="col-md-5">
            <div class="achievement">
                <p class="achieved_acount">{{ $achieved_count }} / {{ $chart_count }}</p>
            </div>
            <h2>ニュース</h2>
            <ul>
                @if (count($news) == 0)
                    <br/>
                    <h3>ニュースはありません</h3>
                @else
                    @foreach ($news as $post)
                        <li>{{ $post->chart->name }} ドンダフルコンボ！({{$post->created_at->format('Y/m/d')}})
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
@endsection