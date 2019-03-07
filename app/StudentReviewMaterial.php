<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class StudentReviewMaterial extends Model
{
    public static function insertByRequest($reviewMaterialId)
    {
        $user = Auth::user();
        $studentReviewMaterial = self::where('review_material_id', $reviewMaterialId)
            ->where('user_id', $user->id)
            ->first();

        if ($studentReviewMaterial) {
            $studentReviewMaterial->touch();
            return $studentReviewMaterial;
        }

        $studentReviewMaterial = new self();
        $studentReviewMaterial->review_material_id = $reviewMaterialId;
        $studentReviewMaterial->user_id = $user->id;
        $studentReviewMaterial->save();
        return $studentReviewMaterial;
    }

    public static function removeByUserLesson($user, $lesson)
    {
        $lesson->review_materials->each(function ($reviewMaterial) use ($user) {
             self::where('review_material_id', $reviewMaterial->id)
                 ->where('user_id', $user->id)
                 ->delete();
        });
    }
}
