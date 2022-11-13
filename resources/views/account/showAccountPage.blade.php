@extends('layouts.app')
@section('content')

@if(!empty($account))
    <div class="width_half" id="profile_posts">
        <div class="card mb-3" style="max-width: 720px">
            <div class="row no-gutters">
                <div class="col-md-4 my-auto">
                    <p class="text-center"><img class="mydon_image" src="https://img.taiko-p.jp/imgsrc.php?v=&kind=mydon&fn=mydon_{{$account->taiko_id}}"/></p>
                    <h4 class="card-title text-center">{{ $account->name }}</h4>
                    <p class="card-text text-center">
                        {{App\Account::$prefs[$account->pref_id]}} / {{App\Account::$ranks[$account->rank_id]}}
                    </p>
                        @if ($is_followed)
                                <div class="px-2 text-center">
                                    <span class="px-1 bg-secondary text-light">フォローされています</span>
                                </div>
                        @else
                                <div class="px-2">
                                    <span class="px-1">  </span>
                                </div>
                        @endif
                            <div class="text-center">
                                @if ($account->id === Auth::user()->id)
                                    <a href="/" class="btn btn-outline-secondary">マイページ</a>
                                @else
                                    @if ($is_following)
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
                            </div>
                    
                </div>
                <div class="col-md-8">
                    <div class="card-body text-center">
                        <div class="width_half">
                            <div class="p-2 d-flex flex-column align-items-center">
                                <p class="font-weight-bold">フォロー</p>
                                <p>{{ $follow_count }}</p>
                            </div>
                            <div class="p-2 d-flex flex-column align-items-center">
                                <p class="font-weight-bold">フォロワー</p>
                                <p>{{ $follower_count }}</p>
                            </div>
                        </div>
                            <h3>現在の達成度</h3>
                            <div class="achievement">
                                <h2 class="achievement_sum">{{ $achieved_count }} / {{ $chart_count }}</h2>
                                <p class="achievement_per">({{$achieved_per}} %)</p>
                            </div>
                            <br />
                            <a href="https://donderhiroba.jp/user_profile.php?taiko_no={{$account->taiko_id}}" class="btn btn-outline-info">ドンだーひろば</a>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <h2>{{$account->name}} さんのニュース</h2>
                @if (count($news) == 0)
                    <br/>
                    <h3>ニュースはありません</h3>
                @else
                    @foreach ($news as $post)
                    <div class="card w-60">
                        <div class="card-haeder d-flex">
                            <div class="d-flex p-3 flex-grow-1">
                                <p>{{$post->created_at->format('Y/m/d')}}：<b>{{ $post->chart->name }}</b> ドンダフルコンボ！</p>
                            </div>
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
                                <p class="text-secondary">{{ count($post->favorites) }}</p>
                        </div>
                    </div>
                    @endforeach
                @endif
        </div>
    </div>
    <div class="content_charts">
        <hr/>
        <p><div class="text-center"><span class="font-size-200per">☆10全良難易度表</span>（最終更新日：{{$chart_updated->format('Y/m/d')}}）</div></p>
        <table id="charts_table">
            @foreach ($difficulties as $difficulty)
                @if (count($charts->where('difficulty', $difficulty)) < 10)
                        <tr>
                            <th class="rs1">{{ $difficulty->difficulty }}</th>
                            @foreach ($charts->where('difficulty', $difficulty) as $chart)
                                    @if (in_array($chart->id, $account_posts))
                                        <td class="chart_{{ $chart->id }}" bgcolor="#ffd700">{{ $chart->name }}</td>
                                    @else
                                        <td class="chart_{{ $chart->id }}">{{ $chart->name }}</td>
                                    @endif
                            @endforeach
                        </tr>
                @elseif (count($charts->where('difficulty', $difficulty)) < 19)
                        <tr>
                            <th class="rs2" rowspan="2">{{ $difficulty->difficulty }}</th>
                            
                            @foreach ($charts->where('difficulty', $difficulty) as $chart)
                                @if ($loop->index <= 8)
                                        @if (in_array($chart->id, $account_posts))
                                            <td class="chart_{{ $chart->id }}" bgcolor="#ffd700">{{ $chart->name }}</td>
                                        @else
                                            <td class="chart_{{ $chart->id }}">{{ $chart->name }}</td>
                                        @endif
                                @endif
                            @endforeach
                        </tr>
                        <tr>
                            @foreach ($charts->where('difficulty', $difficulty) as $chart)
                                @if ($loop->index > 8 )
                                        @if (in_array($chart->id, $account_posts))
                                            <td class="chart_{{ $chart->id }}" bgcolor="#ffd700">{{ $chart->name }}</td>
                                        @else
                                            <td class="chart_{{ $chart->id }}">{{ $chart->name }}</td>
                                        @endif
                                @endif
                            @endforeach
                        </tr>
                @elseif (count($charts->where('difficulty', $difficulty)) < 28)
                        <tr>        
                            <th class="rs3" rowspan="3">{{ $difficulty->difficulty }}</th>
                            @foreach ($charts->where('difficulty', $difficulty) as $chart)
                                @if ($loop->index <= 8)
                                    @if (in_array($chart->id, $account_posts))
                                        <td class="chart_{{ $chart->id }}" bgcolor="#ffd700">{{ $chart->name }}</td>
                                    @else
                                        <td class="chart_{{ $chart->id }}">{{ $chart->name }}</td>
                                    @endif
                                @endif
                            @endforeach
                        </tr>
                        
                        <tr>        
                            @foreach ($charts->where('difficulty', $difficulty) as $chart)
                                @if ($loop->index > 8 && $loop->index <= 17)
                                    @if (in_array($chart->id, $account_posts))
                                        <td class="chart_{{ $chart->id }}" bgcolor="#ffd700">{{ $chart->name }}</td>
                                    @else
                                        <td class="chart_{{ $chart->id }}">{{ $chart->name }}</td>
                                    @endif
                                @endif
                            @endforeach
                        </tr>
                        <tr>        
                            @foreach ($charts->where('difficulty', $difficulty) as $chart)
                                @if ($loop->index > 17)
                                    @if (in_array($chart->id, $account_posts))
                                        <td class="chart_{{ $chart->id }}" bgcolor="#ffd700">{{ $chart->name }}</td>
                                    @else
                                        <td class="chart_{{ $chart->id }}">{{ $chart->name }}</td>
                                    @endif
                                @endif
                            @endforeach
                        </tr>
                @elseif (count($charts->where('difficulty', $difficulty)) < 37)
                        <tr>        
                            <th class="rs4" rowspan="4">{{ $difficulty->difficulty }}</th>
                            @foreach ($charts->where('difficulty', $difficulty) as $chart)
                                @if ($loop->index <= 8)
                                    @if (in_array($chart->id, $account_posts))
                                        <td class="chart_{{ $chart->id }}" bgcolor="#ffd700">{{ $chart->name }}</td>
                                    @else
                                        <td class="chart_{{ $chart->id }}">{{ $chart->name }}</td>
                                    @endif
                                @endif
                            @endforeach
                        </tr>
                        <tr>        
                            @foreach ($charts->where('difficulty', $difficulty) as $chart)
                                @if ($loop->index > 8 && $loop->index <= 17)
                                    @if (in_array($chart->id, $account_posts))
                                        <td class="chart_{{ $chart->id }}" bgcolor="#ffd700">{{ $chart->name }}</td>
                                    @else
                                        <td class="chart_{{ $chart->id }}">{{ $chart->name }}</td>
                                    @endif
                                @endif
                            @endforeach
                        </tr>
                        <tr>        
                            @foreach ($charts->where('difficulty', $difficulty) as $chart)
                                @if ($loop->index > 17 && $loop->index <= 26)
                                    @if (in_array($chart->id, $account_posts))
                                        <td class="chart_{{ $chart->id }}" bgcolor="#ffd700">{{ $chart->name }}</td>
                                    @else
                                        <td class="chart_{{ $chart->id }}">{{ $chart->name }}</td>
                                    @endif
                                @endif
                            @endforeach
                        </tr>
                        <tr>        
                            @foreach ($charts->where('difficulty', $difficulty) as $chart)
                                @if ($loop->index > 26)
                                    @if (in_array($chart->id, $account_posts))
                                        <td class="chart_{{ $chart->id }}" bgcolor="#ffd700">{{ $chart->name }}</td>
                                    @else
                                        <td class="chart_{{ $chart->id }}">{{ $chart->name }}</td>
                                    @endif
                                @endif
                            @endforeach
                        </tr>
                
                @endif
            @endforeach
        </table>
    </div>
@endif
@endsection