@extends('layouts.app')
@section('content')
    <div class="text-center mt-4">
        <h2>ユーザ検索</h2>
    </div>

    <div class="row mt-3 mb-5">
        <div class="col-md-6 offset-md-3">
            <form method="get" action="{{ route('account.search') }}" class="search-form">
            @csrf
                <div class="form-group">
                    <div class="font-weight-bold"><label>プレイヤー名</label></div>
                    <input type="text" name="keyword" value="{{ $search_keyword }}@if(isset($old_keyword)){{ $old_keyword }}@endif" class="form-control" placeholder="どんちゃん">
                    <div class="font-weight-bold"><label for="pref">都道府県</label></div>
                    <select class="form-control" name="pref">                  
                        @foreach($prefs as $key => $pref)
                            <option value="{{ $key }}" @if( isset($old_pref) && (int)$old_pref === $key) selected @endif>
                                {{ $pref }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <div class="font-weight-bold"><label for="rank">現在の段位</label></div>
                    <select class="form-control" name="rank">                          
                        @foreach($ranks as $key => $rank)
                            <option value="{{ $key }}" @if( isset($old_rank) && (int)$old_rank === $key) selected @endif>{{ $rank }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 offset-md-3 text-center"><input type="submit" class="btn primary mt-2" value="検索"></div>

            </form>

        </div>
    </div>
@endsection