<?php

namespace App\Http\Controllers;
use App\Chart;
use App\Genre;
use App\Difficulty;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function create(Difficulty $difficulty, Genre $genre)
    {
        return view('charts.register')->with(['difficulties' => $difficulty->get(),
                                        'genres' => $genre->get()]);
    }
    public function store(Request $request, Difficulty $difficulty, Chart $chart)
    {
        $input_chart = $request['chart'];
        $input_genres = $request->genres_array;  
        
        $chart->fill($input_chart)->save();
        $chart->genres()->attach($input_genres); 
        return redirect('charts/registered/' . $chart->id);
    }
    public function showRegistered(Chart $chart)
    {
        return view('charts.registered')->with(['chart' => $chart]);
    }
    public function showUserPage(Chart $chart, Difficulty $difficulty){
        return view('userpage.userpage')->with(['charts' => $chart->get(), 'difficulties' => $difficulty->get()]);
    }
}
