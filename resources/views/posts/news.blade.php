@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>News</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
        <h1>News</h1>
        <div class='posts'>
            @foreach ($posts as $post)
                <div class='post'>
                    <p class='body'>{{$post->created_at->format('Y/m/d')}}　{{ $post->user_id }} さんが {{$post->chart_name}} をドンダフルコンボ！</p>
                </div>
            @endforeach
        </div>
    </body>
</html>
@endsection