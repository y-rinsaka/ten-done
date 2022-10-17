
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Records</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="/css/style.css" >
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">
    </head>
    <body>
        <h1>プロフィール</h1>
        <div class="profile_table">
            <table border="1" class="margin-auto">
                <tr><th>プレイヤー名</th><td>りんさか</td><th>都道府県</th><td>茨城</td></tr>
                <tr><th>太鼓番</th><td>324498836508</td><th>現在の段位</th><td>超人</td></tr>
                <tr><td><img src="https://img.taiko-p.jp/imgsrc.php?v=&kind=mydon&fn=mydon_324498836508" /></td></tr>
            </table>
            
            
            </p>

            <a href="https://donderhiroba.jp/user_profile.php?taiko_no=324498836508">このプレイヤーのドンだーひろば</a>
        </div>
        <br/>
        <hr/>
        
        <h1>難易度表</h1>
        
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
    
    <hr/>
    <a href="/charts/register">譜面を新規登録する</a>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    </body>
</html>
