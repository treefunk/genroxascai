<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\ReviewMaterial;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use App\Lesson;
use App\Module;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;


class ReviewMaterialsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lessonId = Route::current()->parameters['lesson'];
        $lesson = Lesson::find($lessonId);
        return view('teachers.review_materials.index', compact(['lesson']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lessonId = Route::current()->parameters['lesson'];
        $lesson = Lesson::find($lessonId);
        return view('teachers.review_materials.create', compact(['lesson']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $errors = ReviewMaterial::validateRequest($request);
        if ($errors) {
            return back()->withInput()->withErrors($errors);
        }

        $lessonId = Route::current()->parameters['lesson'];
        $lesson = Lesson::find($lessonId);
        ReviewMaterial::createFromRequest($request, $lesson);

        return redirect()->route('modules.lessons.review-materials.index', [
            'module' => $lesson->module,
            'lesson' => $lesson
        ])->with('success', 'Review Material saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $reviewMaterialId = Route::current()->parameters['review_material'];
        $reviewMaterial = ReviewMaterial::find($reviewMaterialId);
        return view('teachers.review_materials.show',['reviewMaterial' => $reviewMaterial]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
