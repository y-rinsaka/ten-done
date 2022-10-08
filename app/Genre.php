<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    return $this->belongsToMany('App\Chart');
}
