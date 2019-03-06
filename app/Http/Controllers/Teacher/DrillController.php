<?php

namespace App\Http\Controllers\Teacher;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Drill;
use Illuminate\Http\File;
use App\Lesson;
use App\Module;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;


class DrillController extends Controller
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
        return view('teachers.drills.index', compact(['lesson']));
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
        return view('teachers.drills.create', compact(['lesson']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $errors = Drill::validateRequest($request);
        if ($errors) {
            return back()->withInput()->withErrors($errors);
        }

        $lessonId = Route::current()->parameters['lesson'];
        $lesson = Lesson::find($lessonId);
        Drill::createFromRequest($request, $lesson);

        return redirect()->route('modules.lessons.drills.index', [
            'module' => $lesson->module,
            'lesson' => $lesson
        ])->with('success', 'Drill saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $drillId = Route::current()->parameters['drill'];
        $drill = Drill::find($drillId);
        return view('teachers.drills.show',['drill' => $drill]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $drillId = Route::current()->parameters['drill'];
        $drill = Drill::find($drillId);
        return view('teachers.drills.edit', compact(['drill']));
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
        $revieMaterialId = Route::current()->parameters['drill'];
        $lessonId = Route::current()->parameters['lesson'];
        $moduleId = Route::current()->parameters['module'];
        $errors = Drill::validateRequest($request);
        if ($errors) {
            return back()->withInput()->withErrors($errors);
        }
        $drill = Drill::find($revieMaterialId);
        if (!$drill) {
            return back()->withErrors(['errors' => 'Something went wrong']);
        }
        $drill->updateFromRequest($request);
        return redirect()->route('modules.lessons.drills.index', [
            'module' => $moduleId,
            'lesson' => $lessonId,
            'drill' => $revieMaterialId,
            ])->with('success', 'Drill updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $drillId = Route::current()->parameters['drill'];
        $lessonId = Route::current()->parameters['lesson'];
        $moduleId = Route::current()->parameters['module'];
        $drill = Drill::find($drillId);
        if ($drill) {
            $drill->delete();
        }
        return redirect()->route('modules.lessons.drills.index', [
            'module' => $moduleId,
            'lesson' => $lessonId,
            'drill' => $drillId,
            ])->with('success', 'Drill deleted!');
    }
}
