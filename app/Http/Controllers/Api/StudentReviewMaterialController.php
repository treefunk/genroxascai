<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\StudentReviewMaterial;
use App\Http\Controllers\Controller;

class StudentReviewMaterialController extends Controller
{
    public function store()
    {
        $reviewMaterialId = request()->get('review_material_id');
        $studentReviewMaterial = StudentReviewMaterial::insertByRequest($reviewMaterialId);
        return  response()->json($studentReviewMaterial);
    }
}
