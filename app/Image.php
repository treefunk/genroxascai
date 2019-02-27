<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class Image extends Model
{
    const VALID_MIME_TYPES = [
        'image/jpeg',
        'image/jpg',
        'image/png',
        'image/gif',
        'image/bmp',
        'image/svg',
    ];

	protected $fillable = ['caption'];

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
            'caption' => 'max:500',
            // 'description' => 'required|max:1000',
        ];
        if ($request->method() === 'PATCH' || $request->get('id')) {
            $rules['file'] = 'sometimes|required|file';
            $rules['id'] = 'exists:images,id';
            $rules['caption'] = 'max:500';
            // $rules['description'] = 'sometimes|max:1000';
        }

        $validation = Validator::make($request->all(), $rules);
        return $validation->getMessageBag()->all();
    }

    // =============================================================================
    // UTILITIES
    // =============================================================================

    public static function createFromRequest($request)
    {
        $file = Input::file('file');
        $fileExtension = $file->extension();
        return self::createFromData($request->all(), $file->getRealPath(), $fileExtension);
    }

    public static function createFromData($data, $filePath, $fileExtension)
    {
        $fileContents = file_get_contents($filePath);
        $fileName = md5_file($filePath);
        $storedFileName = $fileName . '.' . $fileExtension;
        Storage::put('public/images/' . $storedFileName, $fileContents);
        $image = new self();
        $image->fill($data);
        $image->file_name = $storedFileName;
        $image->save();
        return $image;
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
            Storage::delete('public/images/' . $this->file_name);
        }
        return $result;
    }
}
