@extends('layouts.app')

@section('content')
        <div class="profile_posts">
            <div>
                <table border="1" id="profile_table">
                    
                    <tr><td rowspan="2"><img src="https://img.taiko-p.jp/imgsrc.php?v=&kind=mydon&fn=mydon_{{Auth::user()->taiko_id}}" class="mydon_image"/></td><th>プレイヤー名</th><td>{{Auth::user()->name}}</td><th>都道府県</th><td>{{App\Account::$prefs[Auth::user()->pref_id]}}</td></tr>
                    <tr><th>太鼓番</th><td>{{Auth::user()->taiko_id}}</td><th>現在の段位</th><td>{{App\Account::$ranks[Auth::user()->rank_id]}}</td></tr>
                </table>
                <a href="https://donderhiroba.jp/user_profile.php?taiko_no={{Auth::user()->taiko_id}}">ドンだーひろば</a>
            </div>
            <div>
                <p>最近のニュース</p>
                <ul>
                    <li>全良</li>
    
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
                            <td class="chart"><a href=class="btn btn-primary" data-toggle="modal" data-target="#registerModal{{ $chart->id }}">{{ $chart->name }}</a></td>
                        @endif
                    @endforeach
                    </tr>
                @endforeach
            </table>
                
                   <!-- ボタン・リンククリック後に表示される画面の内容 -->
            @foreach ($charts as $chart)
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
                                <button type="button" class="btn btn-primary">登録</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    <hr/>
    <a href="/charts/register_chart">譜面を新規登録する</a>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
@endsection