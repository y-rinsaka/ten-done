<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chart extends Model
{
    protected $fillable = [
        'name',
        'name_kana',
        'difficulty_id',
        
    ];
    
    public function genres(){
        return $this->belongsToMany('App\Genre');
    }
    public function difficulty(){
        return $this->belongsTo('App\Difficulty');
    }

}
