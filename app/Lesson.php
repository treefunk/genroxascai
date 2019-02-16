<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    public static function boot(){
        parent::boot();

        static::created(function($instance){
            $instance->pre_test()->create([
                'name' => '',
                'type' => 'pre_test',
                'passing_grade' => 60,
            ]);
        });

        static::created(function($instance){
            $instance->post_test()->create([
                'name' => '',
                'type' => 'post_test',
                'passing_grade' => 60,
            ]);
        });
    }
    public function pre_test(){
        return $this->hasOne('App\Test')->where('type','pre_test');
    }

    public function post_test(){
        return $this->hasOne('App\Test')->where('type','post_test');
    }

    public function module(){
        return $this->belongsTo('App\Module');
    }

    public static function findByModule($moduleId) {
        $lessons = self::where('module_id', $moduleId)->get();
        return $lessons;
    }
}
