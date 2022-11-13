@extends('layouts.app')

@section('content')

    <div class="width_half" id="profile_posts">
        <div class="card mb-3" style="max-width: 720px">
            <div class="row no-gutters">
                <div class="col-md-4 my-auto">
                    <div class="text-center">
                    <p><img class="mydon_image" src="https://img.taiko-p.jp/imgsrc.php?v=&kind=mydon&fn=mydon_{{$account->taiko_id}}"/></p>
                    <h4 class="card-title">{{ $account->name }}</h4>
                    <p class="card-text">
                        {{App\Account::$prefs[$account->pref_id]}} / {{App\Account::$ranks[$account->rank_id]}}
                    </p>
                    <div class="px-2">
                        <span class="px-1">  </span>
                    </div>
                    <a href="{{ url('account/' .$account->id .'/edit') }}" class="btn btn-outline-secondary">プロフィール編集</a>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card-body text-center">
                    <div class="width_half">
                        <div class="p-2 d-flex flex-column align-items-center">
                            <p class="font-weight-bold">フォロー</p>
                            <a href="/follow_follower">{{ $follow_count }}</a>
                        </div>
                        <div class="p-2 d-flex flex-column align-items-center">
                            <p class="font-weight-bold">フォロワー</p>
                            <a href="/follow_follower">{{ $follower_count }}</a>
                        </div>
                    </div>
                        <h3>現在の達成状況</h3>
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
                                    @if (in_array($chart->id, $myposts))
                                        <td class="chart_{{ $chart->id }}" bgcolor="#ffd700"><a href=class="btn btn-primary" data-toggle="modal" data-target="#registerModal{{ $chart->id }}">{{ $chart->name }}</a></td>
                                    @else
                                        <td class="chart_{{ $chart->id }}"><a href=class="btn btn-primary" data-toggle="modal" data-target="#registerModal{{ $chart->id }}">{{ $chart->name }}</a></td>
                                    @endif
                            @endforeach
                        </tr>
                @elseif (count($charts->where('difficulty', $difficulty)) < 19)
                        <tr>
                            <th class="rs2" rowspan="2">{{ $difficulty->difficulty }}</th>
                            
                            @foreach ($charts->where('difficulty', $difficulty) as $chart)
                                @if ($loop->index <= 8)
                                        @if (in_array($chart->id, $myposts))
                                            <td class="chart_{{ $chart->id }}" bgcolor="#ffd700"><a href=class="btn btn-primary" data-toggle="modal" data-target="#registerModal{{ $chart->id }}">{{ $chart->name }}</a></td>
                                        @else
                                            <td class="chart_{{ $chart->id }}"><a href=class="btn btn-primary" data-toggle="modal" data-target="#registerModal{{ $chart->id }}">{{ $chart->name }}</a></td>
                                        @endif
                                @endif
                            @endforeach
                        </tr>
                        <tr>
                            @foreach ($charts->where('difficulty', $difficulty) as $chart)
                                @if ($loop->index > 8 )
                                        @if (in_array($chart->id, $myposts))
                                            <td class="chart_{{ $chart->id }}" bgcolor="#ffd700"><a href=class="btn btn-primary" data-toggle="modal" data-target="#registerModal{{ $chart->id }}">{{ $chart->name }}</a></td>
                                        @else
                                            <td class="chart_{{ $chart->id }}"><a href=class="btn btn-primary" data-toggle="modal" data-target="#registerModal{{ $chart->id }}">{{ $chart->name }}</a></td>
                                        @endif
                                @endif
                            @endforeach
                        </tr>
                @elseif (count($charts->where('difficulty', $difficulty)) < 28)
                        <tr>        
                            <th class="rs3" rowspan="3">{{ $difficulty->difficulty }}</th>
                            @foreach ($charts->where('difficulty', $difficulty) as $chart)
                                @if ($loop->index <= 8)
                                    @if (in_array($chart->id, $myposts))
                                        <td class="chart_{{ $chart->id }}" bgcolor="#ffd700"><a href=class="btn btn-primary" data-toggle="modal" data-target="#registerModal{{ $chart->id }}">{{ $chart->name }}</a></td>
                                    @else
                                        <td class="chart_{{ $chart->id }}"><a href=class="btn btn-primary" data-toggle="modal" data-target="#registerModal{{ $chart->id }}">{{ $chart->name }}</a></td>
                                    @endif
                                @endif
                            @endforeach
                        </tr>
                        
                        <tr>        
                            @foreach ($charts->where('difficulty', $difficulty) as $chart)
                                @if ($loop->index > 8 && $loop->index <= 17)
                                    @if (in_array($chart->id, $myposts))
                                        <td class="chart_{{ $chart->id }}" bgcolor="#ffd700"><a href=class="btn btn-primary" data-toggle="modal" data-target="#registerModal{{ $chart->id }}">{{ $chart->name }}</a></td>
                                    @else
                                        <td class="chart_{{ $chart->id }}"><a href=class="btn btn-primary" data-toggle="modal" data-target="#registerModal{{ $chart->id }}">{{ $chart->name }}</a></td>
                                    @endif
                                @endif
                            @endforeach
                        </tr>
                        <tr>        
                            @foreach ($charts->where('difficulty', $difficulty) as $chart)
                                @if ($loop->index > 17)
                                    @if (in_array($chart->id, $myposts))
                                        <td class="chart_{{ $chart->id }}" bgcolor="#ffd700"><a href=class="btn btn-primary" data-toggle="modal" data-target="#registerModal{{ $chart->id }}">{{ $chart->name }}</a></td>
                                    @else
                                        <td class="chart_{{ $chart->id }}"><a href=class="btn btn-primary" data-toggle="modal" data-target="#registerModal{{ $chart->id }}">{{ $chart->name }}</a></td>
                                    @endif
                                @endif
                            @endforeach
                        </tr>
                @elseif (count($charts->where('difficulty', $difficulty)) < 37)
                        <tr>        
                            <th class="rs4" rowspan="4">{{ $difficulty->difficulty }}</th>
                            @foreach ($charts->where('difficulty', $difficulty) as $chart)
                                @if ($loop->index <= 8)
                                    @if (in_array($chart->id, $myposts))
                                        <td class="chart_{{ $chart->id }}" bgcolor="#ffd700"><a href=class="btn btn-primary" data-toggle="modal" data-target="#registerModal{{ $chart->id }}">{{ $chart->name }}</a></td>
                                    @else
                                        <td class="chart_{{ $chart->id }}"><a href=class="btn btn-primary" data-toggle="modal" data-target="#registerModal{{ $chart->id }}">{{ $chart->name }}</a></td>
                                    @endif
                                @endif
                            @endforeach
                        </tr>
                        <tr>        
                            @foreach ($charts->where('difficulty', $difficulty) as $chart)
                                @if ($loop->index > 8 && $loop->index <= 17)
                                    @if (in_array($chart->id, $myposts))
                                        <td class="chart_{{ $chart->id }}" bgcolor="#ffd700"><a href=class="btn btn-primary" data-toggle="modal" data-target="#registerModal{{ $chart->id }}">{{ $chart->name }}</a></td>
                                    @else
                                        <td class="chart_{{ $chart->id }}"><a href=class="btn btn-primary" data-toggle="modal" data-target="#registerModal{{ $chart->id }}">{{ $chart->name }}</a></td>
                                    @endif
                                @endif
                            @endforeach
                        </tr>
                        <tr>        
                            @foreach ($charts->where('difficulty', $difficulty) as $chart)
                                @if ($loop->index > 17 && $loop->index <= 26)
                                    @if (in_array($chart->id, $myposts))
                                        <td class="chart_{{ $chart->id }}" bgcolor="#ffd700"><a href=class="btn btn-primary" data-toggle="modal" data-target="#registerModal{{ $chart->id }}">{{ $chart->name }}</a></td>
                                    @else
                                        <td class="chart_{{ $chart->id }}"><a href=class="btn btn-primary" data-toggle="modal" data-target="#registerModal{{ $chart->id }}">{{ $chart->name }}</a></td>
                                    @endif
                                @endif
                            @endforeach
                        </tr>
                        <tr>        
                            @foreach ($charts->where('difficulty', $difficulty) as $chart)
                                @if ($loop->index > 26)
                                    @if (in_array($chart->id, $myposts))
                                        <td class="chart_{{ $chart->id }}" bgcolor="#ffd700"><a href=class="btn btn-primary" data-toggle="modal" data-target="#registerModal{{ $chart->id }}">{{ $chart->name }}</a></td>
                                    @else
                                        <td class="chart_{{ $chart->id }}"><a href=class="btn btn-primary" data-toggle="modal" data-target="#registerModal{{ $chart->id }}">{{ $chart->name }}</a></td>
                                    @endif
                                @endif
                            @endforeach
                        </tr>
                
                @endif
            @endforeach
        </table>
            
        <!-- モーダル表示 -->
        @foreach ($charts as $chart)
            @if (in_array($chart->id, $myposts))
                <!-- 含まれている場合 -->
                <div class="modal fade" id="registerModal{{ $chart->id }}" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modaltitle" id="myModalLabel">{{ $chart->name }}</h4>
                            </div>
                            <div class="modal-body">
                                <label>        
                                    <p>難易度帯：{{ $chart->difficulty->difficulty }}</p>
                            
                                    @foreach($chart->genres as $genre)
                                        <p>●{{ $genre->name }}</p> 
                                    @endforeach            
                                    <h3>取り消しますか？</h3>
                                </label>
                            </div>
                            <div class="modal-footer">
                                
                                <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
                                <form action="{{ route('delete', $chart) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" class="btn btn-danger" name="delete_button" value="取消">
                                </form>
                            </div>
                        </div>
                    </div>
                </div> 
            @else
                <div class="modal fade" id="registerModal{{ $chart->id }}" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modaltitle" id="myModalLabel">{{ $chart->name }}</h4>
                            </div>
                            <div class="modal-body">
                                <label>        
                                    <p>難易度帯：{{ $chart->difficulty->difficulty }}</p>
                            
                                    @foreach($chart->genres as $genre)
                                        <p>●{{ $genre->name }}</p> 
                                    @endforeach                            
                                </label>
                            </div>
                            <div class="modal-footer">
                                
                                <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
                                <form action="/" method="post">
                                    @csrf
                                    <input type="hidden" name="post[user_id]" value="{{ Auth::user()->id }}">
                                    <input type="hidden" name="post[chart_id]" value="{{ $chart->id }}">
                                    <input type="submit" class="btn btn-primary" name="register_button" value="登録">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
    <hr/>
    <a href="/charts/register_chart">譜面を新規登録する</a>

@endsection