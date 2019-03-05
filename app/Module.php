<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class Module extends Model
{
    protected $fillable = ['name','is_open','order', 'description'];


    // =============================================================================
    // QUERIES
    // =============================================================================

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

        $file = Input::file('file');
        if ($file) {
             $fileExtension = $file->extension();
            $this->saveImage($file, $fileExtension);
        }
       
        $this->fill($request->all());
        $this->is_open = (bool) $request->get('is_open');
        $this->save();

        return $this;
    }

    public function saveImage($filePath, $fileExtension)
    {
        $fileContents = file_get_contents($filePath);
        $fileName = md5_file($filePath) . rand();
        $storedFileName = $fileName . '.' . $fileExtension;
        Storage::put('public/images/modules/' . $storedFileName, $fileContents);
        $this->file_name = $storedFileName;
        return $this->save();
    }

    // =============================================================================
    // ADDITIONAL PROPERTIES
    // =============================================================================

    // =============================================================================
    // RELATIONSHIPS
    // =============================================================================

    public function periodicaltest()
    {
        return $this->hasOne('App\Test')->where('type',  Test::TYPE_PERIODICALTEST);
    }

    public function lessons()
    {
        return $this->hasMany('App\Lesson')->orderBy('order');
    }

    // =============================================================================
    // HOOKS / OVERRIDE
    // =============================================================================

    public static function boot()
    {
        parent::boot();

        static::created(function($instance){
            $instance->periodicaltest()->create([
                'name' => '',
                'type' => Test::TYPE_PERIODICALTEST,
                'passing_grade' => 60,
                'time_limit' => 25,
                'is_open' => false
            ]);
        });

    }
}
