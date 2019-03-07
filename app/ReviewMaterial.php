<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class ReviewMaterial extends Model
{
    const VALID_MIME_TYPES = [
        'application/x-shockwave-flash',
        'video/mp4',
    ];

    protected $fillable = [
        'name',
        'description',
        'is_open'
    ];

    // =============================================================================
    // QUERIES
    // =============================================================================

    public static function getByLessonId($lessonId)
    {
        $reviewMaterials = self::where('lesson_id', $lessonId)->get();
        return $reviewMaterials;
    }

    // =============================================================================
    // VALIDATIONS
    // =============================================================================

    public static function validateRequest($request)
    {
        $rules = [
            'file' => 'required|mimetypes:' . implode(',', self::VALID_MIME_TYPES),
            'name' => 'required|max:255',
            'description' => 'required|max:1000',
        ];
        if ($request->method() === 'PATCH' || $request->get('id')) {
            $rules['file'] = 'sometimes|required|file';
            $rules['id'] = 'exists:review_materials,id';
            $rules['name'] = 'sometimes|max:255';
            $rules['description'] = 'sometimes|max:1000';
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

        $file = Input::file('file');
        if ($file) {
            $fileExtension = $file->extension();
            $fileContents = file_get_contents($file->getRealPath());
            $fileName = md5_file($file->getRealPath()) . rand();
            $storedFileName = $fileName . '.' . $fileExtension;
            Storage::delete('public/review-materials/' . $this->file_name);
            Storage::put('public/review-materials/' . $storedFileName, $fileContents);
            $this->file_name = $storedFileName;
            $this->mime_type = mime_content_type($file->getRealPath());
        }
        $this->save();
        return $this;
    }

    public static function createFromRequest($request, $lesson)
    {
        $file = Input::file('file');
        $fileExtension = $file->extension();
        return self::createFromData($request->all(), $lesson, $file->getRealPath(), $fileExtension);
    }

    public static function createFromData($data, $lesson, $filePath, $fileExtension)
    {
        $fileContents = file_get_contents($filePath);
        $fileName = md5_file($filePath) . rand();
        $storedFileName = $fileName . '.' . $fileExtension;
        Storage::put('public/review-materials/' . $storedFileName, $fileContents);
        $reviewMaterial = new self();
        $reviewMaterial->fill($data);
        $reviewMaterial->file_name = $storedFileName;
        $reviewMaterial->mime_type = mime_content_type($filePath);
        $reviewMaterial->lesson_id = $lesson->id;
        $reviewMaterial->save();
        return $reviewMaterial;
    }

    public static function hasAccessAllByUserModule($user, $module)
    {
        $hasAccessAll = true;
        $module = Module::find($module->id); // need to construct like this because of error (weird, no time to debug)
        $module->lessons->each(function ($lesson) use ($user, &$hasAccessAll) {
            $hasAccessAll = self::hasAccessAllByUserLesson($user, $lesson);
            if (!$hasAccessAll) {
                return false;
            }
        });
        return $hasAccessAll;
    }

    public static function hasAccessAllByUserLesson($user, $lesson)
    {
        $hasAccessAll = true;
        $lesson->review_materials->each(function ($reviewMaterial) use ($user, &$hasAccessAll) {
            if (!$reviewMaterial->is_open) {
                return true;
            }
            $studentReviewMaterial = StudentReviewMaterial::getByUserReviewMaterial($user, $reviewMaterial);
            if (!$studentReviewMaterial) {
                $hasAccessAll = false;
                return false;
            }
        });
        return $hasAccessAll;
    }

    // =============================================================================
    // ADDITIONAL PROPERTIES
    // =============================================================================

    // =============================================================================
    // RELATIONSHIPS
    // =============================================================================
    
    public function lesson()
    {
        return $this->belongsTo('App\Lesson');
    }

    // =============================================================================
    // HOOKS / OVERRIDE
    // =============================================================================

    public function delete(array $options = [])
    {
        $result = parent::delete();
        if ($result) {
            Storage::delete('public/review-materials/' . $this->file_name);
        }
        return $result;
    }
}
