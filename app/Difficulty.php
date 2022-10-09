<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Difficulty extends Model
{
    public function charts(){
        return $this->hasMany('App\Chart'); 
    }
    public function getByDifficulty(){
        return $this->charts()->first();
    }
}
