@extends('layouts.app')
@section('content')

<h2>ニュース</h2>
<div class='posts'>

    @foreach ($posts as $post)
    
        <div class='post'>
            <p class='body'>{{ $post->created_at->format('Y/m/d') }}　{{ $post->account->name }} さんが <b>{{ $post->chart->name }}</b> をドンダフルコンボ！</p>
        </div>
    @endforeach

</div>
@endsection