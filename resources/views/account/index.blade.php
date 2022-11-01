@extends('layouts.app')

@section('content')
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
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
                        @if (in_array($chart->id, $myposts))
                            <td class="chart_{{ $chart->id }}" bgcolor="#ffd700"><a href=class="btn btn-primary" data-toggle="modal" data-target="#registerModal{{ $chart->id }}">{{ $chart->name }}</a></td>
                        @else
                            <td class="chart_{{ $chart->id }}"><a href=class="btn btn-primary" data-toggle="modal" data-target="#registerModal{{ $chart->id }}">{{ $chart->name }}</a></td>
                        @endif
                    @endif
                @endforeach
                </tr>
            @endforeach
        </table>
            
        <!-- モーダル表示 -->
        @foreach ($charts as $chart)
            @if (in_array($chart->id, $myposts))
                <!-- 含まれている場合 -->
                <div class="modal fade" id="registerModal{{ $chart->id }}" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modaltitle" id="myModalLabel">{{ $chart->name }}</h4>
                            </div>
                            <div class="modal-body">
                                <label>        
                                    <p>難易度帯：{{ $chart->difficulty->name }}</p>
                            
                                    @foreach($chart->genres as $genre)
                                        <p>●{{ $genre->name }}</p> 
                                    @endforeach            
                                    <h3>取り消しますか？</h3>
                                </label>
                            </div>
                            <div class="modal-footer">
                                
                                <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
                                <form action="{{ route('delete', $chart) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" class="btn btn-danger" name="delete_button" value="取消">
                                </form>
                            </div>
                        </div>
                    </div>
                </div> 
            @else
                <div class="modal fade" id="registerModal{{ $chart->id }}" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modaltitle" id="myModalLabel">{{ $chart->name }}</h4>
                            </div>
                            <div class="modal-body">
                                <label>        
                                    <p>難易度帯：{{ $chart->difficulty->name }}</p>
                            
                                    @foreach($chart->genres as $genre)
                                        <p>●{{ $genre->name }}</p> 
                                    @endforeach                            
                                </label>
                            </div>
                            <div class="modal-footer">
                                
                                <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
                                <form action="/" method="post">
                                    @csrf
                                    <input type="hidden" name="post[user_id]" value="{{ Auth::user()->id }}">
                                    <input type="hidden" name="post[chart_id]" value="{{ $chart->id }}">
                                    <input type="submit" class="btn btn-primary" name="register_button" value="登録">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
    <hr/>
    <a href="/charts/register_chart">譜面を新規登録する</a>

@endsection