<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{
    protected $fillable = [
        'text','is_correct'
    ];
}
