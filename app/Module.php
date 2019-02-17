<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Module extends Model
{
    protected $fillable = ['name','is_open','order'];


    // =============================================================================
    // QUERIES
    // =============================================================================
    public static function getOpen()
    {
        return self::where('is_open', 1)->get();
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
            $rules['id'] = 'exists:modules,id';
        }

        $validation = Validator::make($request->all(), $rules);
        return $validation->getMessageBag()->all();
    }

    // =============================================================================
    // UTILITIES
    // =============================================================================

    // =============================================================================
    // ADDITIONAL PROPERTIES
    // =============================================================================

    // =============================================================================
    // RELATIONSHIPS
    // =============================================================================

    public function lessons()
    {
        return $this->hasMany('App\Lesson')->orderBy('order');
    }

    // =============================================================================
    // HOOKS / OVERRIDE
    // =============================================================================


}
