<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

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

    public function questionsByType($type,$json = false){
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

    public function updateFromRequest($request) {
        $this->fill($request->all());
        $this->is_open = (bool) $request->get('is_open'); // fix typecasting
        $this->save();
        return $this;
    }

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
