<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    public function charts(){
        return $this->belongsToMany('App\Chart');
    }
}
