
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Records</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="/css/style.css" >
    </head>
    <body>
        <h1>プロフィール</h1>
        <div class="profile">
            <table>
                <tr>
                    <td>
                        <img src="https://img.taiko-p.jp/imgsrc.php?v=&kind=mydon&fn=mydon_324498836508" height="50%" width="50%"/>
                    </td>
                    <td>
                        <table border="1">
                            <tr><th>プレイヤー名</th><td>りんさか</td><th>都道府県</th><td>茨城</td></tr>
                            <tr><th>太鼓番</th><td>324498836508</td><th>現在の段位</th><td>超人</td></tr>
                            
                        </table>
                        <a href="https://donderhiroba.jp/user_profile.php?taiko_no=324498836508">このプレイヤーのドンだーひろば</a>
                    </td>
            </table>
        </div>
        
        
        <h2>難易度表</h2>
        
        <table id="charts_table">
            @foreach ($difficulties as $difficulty)
                <tr>
                    <th>{{ $difficulty->name }}</th>
                @foreach ($charts as $chart)
                    @if ($chart->difficulty->name === $difficulty->name)
                        <td><a href="#">{{ $chart->name }}</a></td>
                    @endif
                @endforeach
                </tr>
            @endforeach
        </table>
    </body>
</html>
