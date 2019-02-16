<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = ['name','is_open','order'];

    public function lessons(){
        return $this->hasMany('App\Lesson');
    }
}
