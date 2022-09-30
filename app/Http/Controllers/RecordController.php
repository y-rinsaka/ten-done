<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RecordController extends Controller
{
    public function record( $post)
    {
        return view('charts/index');
    }
}
