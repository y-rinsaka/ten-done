<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function account(){
        return $this->belongsTo(Account::class, 'user_id');
    }
    public function chart(){
        return $this->belongsTo('App\Chart');
    }
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
    
    protected $fillable = [
        'user_id', 'chart_id',
    ];

    protected $dates = ['created_at', 'updated_at',];
    
}
