<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = ['name','module_id','description','order'];

    // =============================================================================
    // QUERIES
    // =============================================================================

    public static function findByModule($moduleId)
    {
        $lessons = self::where('module_id', $moduleId)->get();
        return $lessons;
    }

    // =============================================================================
    // VALIDATIONS
    // =============================================================================

    // =============================================================================
    // UTILITIES
    // =============================================================================

    // =============================================================================
    // ADDITIONAL PROPERTIES
    // =============================================================================

    // =============================================================================
    // RELATIONSHIPS
    // =============================================================================

    public function pre_test()
    {
        return $this->hasOne('App\Test')->where('type','pre_test');
    }

    public function post_test()
    {
        return $this->hasOne('App\Test')->where('type','post_test');
    }

    public function module()
    {
        return $this->belongsTo('App\Module');
    }

    // =============================================================================
    // HOOKS / OVERRIDE
    // =============================================================================

    public static function boot()
    {
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
}
