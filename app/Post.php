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
    
    protected $fillable = [
        'user_id', 'chart_id',
    ];

    protected $dates = ['created_at', 'updated_at',];
    
    public function getPaginateByLimit(int $limit_count = 10)
    {
        // updated_atで降順に並べたあと、limitで件数制限をかける
        return $this::with('account')->orderBy('updated_at', 'DESC')->paginate($limit_count);
        
    }
}
