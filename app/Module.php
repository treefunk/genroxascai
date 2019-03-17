<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class Module extends Model
{
    protected $fillable = ['name','is_open','order', 'description'];
    protected $appends = [
        'is_locked'
    ];


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

    public function getPrevious()
    {
        return self::where('order', $this->order - 1)->first();
    }

    public function getLastLesson()
    {
        return $this->lessons->sortByDesc('order')->first();
    }

    // =============================================================================
    // ADDITIONAL PROPERTIES
    // =============================================================================

    public function getIsLockedAttribute()
    {
        if ($this->order < 2) {
            return false;
        }

        $user = Auth::user();

        $isPostTestsPassed = true;
        $lessons = $this->getPrevious()->lessons;
        $lessons->each(function ($lesson) use ($user, &$isPostTestsPassed) {
            $test = $user->getHighestUserTestByTest($lesson->posttest);
            if (!$test || !$test->isPassed()) {
                $isPostTestsPassed = false;
                return false;
            }
        });

        $hasAccessedAllReviewMaterials = ReviewMaterial::hasAccessAllByUserModule($user, $this->getPrevious());
        if ($hasAccessedAllReviewMaterials && $isPostTestsPassed) {
            return false;
        }
        return true;
    }

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
