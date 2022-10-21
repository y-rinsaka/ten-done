@extends('layouts.app')
@section('content')

<h1>News</h1>
<div class='posts'>

    @foreach ($posts as $post)
        <div class='post'>
            <p class='body'>{{ $post->created_at->format('Y/m/d') }}　{{ $post->account->name }} さんが {{ $post->chart_name }} をドンダフルコンボ！</p>
        </div>
    @endforeach

</div>
@endsection