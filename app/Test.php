<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $fillable = [
        'name',
        'passing_grade',
        'type'
    ];

    public function questions(){
        return $this->hasMany('App\Question');
    }
}
