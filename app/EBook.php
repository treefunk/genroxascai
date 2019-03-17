<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class EBook extends Model
{
    const VALID_MIME_TYPES = [
        'application/pdf',
    ];

    protected $fillable = [
        'name',
        'description',
        'is_open'
    ];

    protected $table = 'ebooks';

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
            $rules['id'] = 'exists:ebook,id';
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
            Storage::delete('public/ebooks/' . $this->file_name);
            Storage::put('public/ebooks/' . $storedFileName, $fileContents);
            $this->file_name = $storedFileName;
            $this->mime_type = mime_content_type($file->getRealPath());
        }
        $this->save();
        return $this;
    }

    public static function createFromRequest($request)
    {
        $file = Input::file('file');
        $fileExtension = $file->extension();
        return self::createFromData($request->all(), $file->getRealPath(), $fileExtension);
    }

    public static function createFromData($data, $filePath, $fileExtension)
    {
        $fileContents = file_get_contents($filePath);
        $fileName = md5_file($filePath) . rand();
        $storedFileName = $fileName . '.' . $fileExtension;
        Storage::put('public/ebooks/' . $storedFileName, $fileContents);
        $eBook = new self();
        $eBook->fill($data);
        $eBook->file_name = $storedFileName;
        $eBook->mime_type = mime_content_type($filePath);
        $eBook->save();
        return $eBook;
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

    public function delete(array $options = [])
    {
        $result = parent::delete();
        if ($result) {
            Storage::delete('public/ebooks/' . $this->file_name);
        }
        return $result;
    }
}
