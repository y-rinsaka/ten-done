@extends('layouts.app')
@section('content')

<h2>ニュース</h2>
<div class='posts'>
<ul>
    @forelse ($posts as $post)
        <li class='post'>
            {{ $post->created_at->format('Y/m/d') }}　<a href="/account/{{$post->user_id}}">{{ $post->account->name }}</a> さんが <b>{{ $post->chart->name }}</b> をドンダフルコンボ！
        </li>
        @empty
            <p>ニュースはありません</p>
    @endforelse
</ul>
</div>
{{ $posts->appends(request()->input())->render('pagination::bootstrap-4') }}
@endsection