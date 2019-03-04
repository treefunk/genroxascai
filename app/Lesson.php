<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use App\Test;

class Lesson extends Model
{
    protected $fillable = ['name','module_id','description','order', 'is_open'];

    // =============================================================================
    // QUERIES
    // =============================================================================

    public static function getByModuleId($moduleId)
    {
        $lessons = self::where('module_id', $moduleId)->get();
        return $lessons;
    }

    public function questionsByType($type, $json = false)
    {
        $query = $this->{$type}->questions()->with('choices')->get();

        return $json ? $query->toJson() : $query;
    }

    // =============================================================================
    // VALIDATIONS
    // =============================================================================

    public static function validateRequest($request)
    {
        $rules = [
            'name' => 'required|max:255',
        ];

        if ($request->method() === 'PATCH' || $request->get('id')) {
            $rules['id'] = 'exists:lessons,id';
            $rules['name'] = 'sometimes|max:255';
        }

        $validation = Validator::make($request->all(), $rules);
        return $validation->getMessageBag()->all();
    }

    // =============================================================================
    // UTILITIES
    // =============================================================================

    public function updateFromRequest($request)
    {
        $this->fill($request->all());
        $this->is_open = (bool) $request->get('is_open');
        $this->save();
        return $this;
    }

    public function getPrevious()
    {
        return self::where('order', $this->order - 1)->first();
    }

    // =============================================================================
    // ADDITIONAL PROPERTIES
    // =============================================================================

    // =============================================================================
    // RELATIONSHIPS
    // =============================================================================

    public function pretest()
    {
        return $this->hasOne('App\Test')->where('type', Test::TYPE_PRETEST);
    }

    public function posttest()
    {
        return $this->hasOne('App\Test')->where('type',  Test::TYPE_POSTTEST);
    }

    public function module()
    {
        return $this->belongsTo('App\Module');
    }

    public function review_materials()
    {
        return $this->hasMany('App\ReviewMaterial');
    }

    public function drills()
    {
      return $this->hasMany('App\Drill');
    }
    // =============================================================================
    // HOOKS / OVERRIDE
    // =============================================================================

    public static function boot()
    {
        parent::boot();

        static::created(function($instance){
            $instance->pretest()->create([
                'name' => '',
                'type' => Test::TYPE_PRETEST,
                'passing_grade' => 60,
                'time_limit' => 10,
                'is_open' => true
            ]);
        });

        static::created(function($instance){
            $instance->posttest()->create([
                'name' => '',
                'type' =>Test::TYPE_POSTTEST,
                'passing_grade' => 60,
                'time_limit' => 15,
            ]);
        });
    }
}
