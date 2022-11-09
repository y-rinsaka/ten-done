@extends('layouts.app')
@section('content')

<h2>ニュース</h2>
<div class='posts'>
<ul>
    @foreach ($posts as $post)
        <li class='post'>
            {{ $post->created_at->format('Y/m/d') }}　<a href="/account/{{$post->account->id}}">{{ $post->account->name }}</a> さんが <b>{{ $post->chart->name }}</b> をドンダフルコンボ！

            <div class="d-flex align-items-center">
                @if (!in_array(Auth::user()->id, array_column($post->favorites->toArray(), 'user_id'), TRUE))
                    <form method="POST" action="{{ url('favorites/') }}" class="mb-0">
                        @csrf

                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <button type="submit" class="btn p-0 border-0 text-primary"><i class="far fa-heart fa-fw"></i></button>
                    </form>
                @else
                    <form method="POST"action="{{ url('favorites/' .array_column($post->favorites->toArray(), 'id', 'user_id')[Auth::user()->id]) }}" class="mb-0">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn p-0 border-0 text-danger"><i class="fas fa-heart fa-fw"></i></button>
                    </form>
                @endif
                <p class="mb-0 text-secondary">{{ count($post->favorites) }}</p>
            </div>
        </li>
    @endforeach
</ul>
</div>
{{ $posts->appends(request()->input())->render('pagination::bootstrap-4') }}
@endsection