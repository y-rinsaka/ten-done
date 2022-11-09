@extends('layouts.app')
@section('content')
<div class="text-center mt-4">
        <h2>検索結果</h2>
        <p>検索ワード：{{$search_keyword}}</p>

        
        @if(isset($search_pref) && $search_pref != 0)
            @foreach($prefs as $key => $pref)
                @foreach($accounts as $account)
                    @if($key == $account->pref_id)
                        <span class="ml-4">都道府県：{{ $pref }}</span>
                        @php
                            break;
                        @endphp
                    @endif
                @endforeach
            @endforeach
        @else
            @if ($search_pref == 0)
            <span class="ml-4">都道府県：指定なし</span>
            @endif
        @endif

        @if(isset($search_rank) && $search_rank != 0)
            @foreach($ranks as $key => $rank)
                @foreach($accounts as $account)
                    @if($key == $account->rank_id)    
                        <span class="ml-4">現在の段位：{{ $rank }}</span>
                        @php
                            break;
                        @endphp
                    @endif 
                @endforeach
            @endforeach
        @else
            @if ($search_pref == 0)
            <span class="ml-4">現在の段位：指定なし</span>
            @endif
        @endif
<br />
<div class= "row d-inline-flex center">
        @foreach($accounts as $account)
        <div class ="col-6 col-sm-4 col-md-3 p-2">
            <div class="card h-100">
                <br />
                <p class="text-center"><a href="/account/{{ $account->id }}"><img class="mydon_image_at_search" src="https://img.taiko-p.jp/imgsrc.php?v=&kind=mydon&fn=mydon_{{$account->taiko_id}}"/></a></p>
                <h4 class="card-title text-center">{{ $account->name }}</h4>
                <p class="card-text text-center">
                    {{App\Account::$prefs[$account->pref_id]}} / {{App\Account::$ranks[$account->rank_id]}}
                </p>
                <p class="card-text text-center">
                    @if ($account->id === Auth::user()->id)
                    <div>
                        <a href="/" class="btn btn-outline-dark">マイページ</a>
                    </div>
                    @else
                        @if (auth()->user()->isFollowing($account->id))
                            <form action="{{ route('unfollow', $account->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-primary">フォロー中</button>
                            </form>
                        @else
                            <form action="{{ route('follow', $account->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary">フォローする</button>
                            </form>
                        @endif
                    @endif
                </p>
                <p class="card-text text-center">
                    @if (auth()->user()->isFollowed($account->id))
                        <div class="px-2">
                            <span class="px-1 bg-secondary text-light">フォローされています</span>
                        </div>
                    @endif
                </p>
            </div>
        </div>
        @endforeach
</div>


    @if($accounts->isEmpty())
        <div class="text-center mt-5">
            <p class="mt-4">{{ "検索条件と一致するアカウントは存在しません。" }}</p>
        </div>
    @endif

    <div class="row justify-content-center mb-3">
        <a class="text-decoration-none mt-2" href="/searchInput" name="back" style="color: gray;">検索画面へ戻る</a>
    </div>
@endsection
