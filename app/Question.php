<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'text'
    ];

    public function test(){
        return $this->belongsTo('App\Test');
    }

    public function choices(){
        return $this->hasMany('App\Choice');
    }
}
