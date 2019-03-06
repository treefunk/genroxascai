<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class Drill extends Model
{
const VALID_MIME_TYPES = [
        'application/x-shockwave-flash',
    ];

    protected $fillable = [
        'name',
        'is_open'
    ];

    // =============================================================================
    // QUERIES
    // =============================================================================

    public static function getByLessonId($lessonId)
    {
        $drills = self::where('lesson_id', $lessonId)->get();
        return $drills;
    }

    // =============================================================================
    // VALIDATIONS
    // =============================================================================

    public static function validateRequest($request)
    {
        $rules = [
            'file' => 'required|mimetypes:' . implode(',', self::VALID_MIME_TYPES),
            'name' => 'required|max:255',
        ];
        if ($request->method() === 'PATCH' || $request->get('id')) {
            $rules['file'] = 'sometimes|required|file';
            $rules['id'] = 'exists:drills,id';
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

        $file = Input::file('file');
        if ($file) {
            $fileExtension = $file->extension();
            $fileContents = file_get_contents($file->getRealPath());
            $fileName = md5_file($file->getRealPath()) . rand();
            $storedFileName = $fileName . '.' . $fileExtension;
            Storage::delete('public/drills/' . $this->file_name);
            Storage::put('public/drills/' . $storedFileName, $fileContents);
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
        Storage::put('public/drills/' . $storedFileName, $fileContents);
        $drill = new self();
        $drill->fill($data);
        $drill->file_name = $storedFileName;
        $drill->mime_type = mime_content_type($filePath);
        $drill->lesson_id = $lesson->id;
        $drill->save();
        return $drill;
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
            Storage::delete('public/drills/' . $this->file_name);
        }
        return $result;
    }
}
