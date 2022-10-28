@extends('layouts.app')

@section('content')
        <div class="profile_posts">
            <div>
                <h2>プロフィール</h2>
                <table border="1" id="profile_table">
                    <tr><td rowspan="2"><img src="https://img.taiko-p.jp/imgsrc.php?v=&kind=mydon&fn=mydon_{{Auth::user()->taiko_id}}" class="mydon_image"/></td><th>プレイヤー名</th><td>{{Auth::user()->name}}</td><th>都道府県</th><td>{{App\Account::$prefs[Auth::user()->pref_id]}}</td></tr>
                    <tr><th>太鼓番</th><td>{{Auth::user()->taiko_id}}</td><th>現在の段位</th><td>{{App\Account::$ranks[Auth::user()->rank_id]}}</td></tr>
                </table>
                <a href="https://donderhiroba.jp/user_profile.php?taiko_no={{Auth::user()->taiko_id}}">ドンだーひろば</a>
            </div>
            <div>
                <h2>マイニュース</h2>
                <ul>
                    @foreach ($posts as $post)
                        @if ($post->user_id === Auth::user()->id)
                            <li>{{ $post->chart->name }} ドンダフルコンボ！({{$post->created_at->format('Y/m/d')}})</li>
                        @endif
                    @endforeach
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
                            <td class="chart_{{ $chart->id }}">{{ $chart->name }}</td>
                        @endif
                    @endforeach
                    </tr>
                @endforeach
            </table>
        </div>
    <hr/>
    <a href="/charts/register_chart">譜面を新規登録する</a>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
@endsection