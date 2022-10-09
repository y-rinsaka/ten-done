<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>登録完了</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
        <h1>登録完了</h1>
        <h2></h2>
        <p>{{ $chart->difficulty->difficulty }}</p>
        
        <a href="/charts/register">[登録する]</a>
    </body>
</html>