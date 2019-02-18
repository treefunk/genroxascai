<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Lesson;
use App\Module;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;


class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $moduleId = Route::current()->parameters['module'];
        $lessons = Lesson::getByModuleId($moduleId);
        $module = Module::find($moduleId);
        return view('teachers.lessons.index',[
            'lessons' => $lessons,
            'module' => $module
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $moduleId = Route::current()->parameters['module'];
        $module = Module::find($moduleId);

        return view('teachers.lessons.create', [
            'module' => $module
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->all();
        $moduleId = Route::current()->parameters['module'];
        $module = Module::find($moduleId);
        $order = Lesson::getByModuleId($moduleId)->count() + 1;

        $errors = Lesson::validateRequest($request);
        if ($errors) {
            return back()->withInput()->withErrors($errors);
        }

        $lessons = Lesson::create(
            $request->all() + [
            'order' => $order, 
            'module_id' => $module->id
        ]);

        return redirect()->route('modules.lessons.index', [
            'module' => $module
            ])->with('success', 'Lesson saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($module_id, $lesson_id)
    {
      //  $moduleId = Route::current()->parameter('module_id');
        $lessonId = Route::current()->parameters['lesson'];
        $lesson = Lesson::find($lessonId);
        return view('teachers.lessons.show',['lesson' => $lesson]);
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
        $lessonId = Route::current()->parameters['lesson'];
        $errors = Lesson::validateRequest($request);
        if ($errors) {
            return back()->withInput()->withErrors($errors);
        }
        $lesson = Lesson::find($lessonId);
        if (!$lesson) {
            return back()->withErrors(['errors' => 'Something went wrong']);
        }
        $lesson->updateFromRequest($request);
        return back()->with('success', 'Lesson updated!');
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
