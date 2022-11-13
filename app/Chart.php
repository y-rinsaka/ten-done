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
    public function posts(){
        return $this->hasMany('App\Post');
    }
    public function getUpdated(){
        $chart_updated = \App\Chart::latest('updated_at')->pluck('updated_at')->first();
        return $chart_updated;
    }
}
