<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>登録完了</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
        <h1>登録完了</h1>
        <h2>{{ $chart->name }} ({{ $chart->name_kana }})</h2>
        <p>難易度帯：{{ $chart->difficulty->difficulty }}</p>
        <p>ジャンル：</p>
        <ul>
        @foreach($chart->genres as $genre)   
            <li>{{ $genre->name }}</li>
        @endforeach
        </ul>
        <a href="/charts/register_chart">[登録ページに戻る]</a>
    </body>
</html>