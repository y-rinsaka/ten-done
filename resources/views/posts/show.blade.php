@extends('layouts.app')
@section('content')

<h2>ニュース</h2>
<div class='posts'>
<ul>
    @foreach ($posts as $post)
    
        <li class='post'>
            {{ $post->created_at->format('Y/m/d') }}　{{ $post->account->name }} さんが <b>{{ $post->chart->name }}</b> をドンダフルコンボ！
        </li>
    @endforeach
</ul>
</div>
{{ $posts->appends(request()->input())->render('pagination::bootstrap-4') }}
@endsection