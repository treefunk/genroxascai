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
            'file' => 'required|mimetypes:' . implode(',', self::VALID_MIME_TYPES),
            'name' => 'required|max:255',
            'description' => 'required|max:1000',
        ];
        if ($request->method() === 'PATCH' || $request->get('id')) {
            $rules['file'] = 'sometimes|required|file';
            $rules['id'] = 'exists:review_materials,id';
        }

        $validation = Validator::make($request->all(), $rules);
        return $validation->getMessageBag()->all();
    }
    // =============================================================================
    // UTILITIES
    // =============================================================================

    public static function createFromRequest($request, $lesson)
    {
        $file = Input::file('file');
        $fileExtension = $file->extension();
        return self::createFromData($request->all(), $lesson, $file->getRealPath(), $fileExtension);
    }

    public static function createFromData($data, $lesson, $filePath, $fileExtension)
    {
        $fileContents = file_get_contents($filePath);
        $fileName = md5_file($filePath);
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

}
