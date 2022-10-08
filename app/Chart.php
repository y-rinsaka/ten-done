<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chart extends Model
{
    return $this->belongsTo('App\Difficulty');
    return $this->belongsToMany('App\Genre');
}
