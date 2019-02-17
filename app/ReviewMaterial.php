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
        'application/vnd.apple.mpegurl',
        'application/x-mpegurl',
        'application/x-shockwave-flash',
        'video/3gpp',
        'video/mp4',
        'video/mpeg',
        'video/ogg',
        'video/quicktime',
        'video/webm',
        'video/x-m4v',
        'video/ms-asf',
        'video/x-ms-wmv',
        'video/x-msvideo',
        'video/x-flv',
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
            'description' => 'sometimes|max:1000',
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

        $fileContents = file_get_contents($file->getRealPath());
        $fileName = md5_file($file->getRealPath());
        $fileExtension = $file->extension($fileName);

        $storedFileName = $fileName . '.' . $fileExtension;
        Storage::put('public/review-materials/' . $storedFileName, $fileContents);
        $reviewMaterial = new self();
        $reviewMaterial->fill($request->all());
        $reviewMaterial->file_name = $storedFileName;
        $reviewMaterial->mime_type = $file->getMimeType();
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

    // =============================================================================
    // HOOKS / OVERRIDE
    // =============================================================================

}
