<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
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
        return view('teachers.review_materials.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


        return view('teachers.review_materials.create');
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
        $moduleId = $request->module_id;
        $order = Lesson::findByModule($moduleId)->count() + 1;

        $lessons = Lesson::create(
            $request->all() + ['order' => $order]
        );

        // $lessons = Lesson::findByModule($moduleId);
        return redirect(route('lessons.index',['module_id' => $moduleId]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //  $moduleId = Route::current()->parameter('module_id');
        $lesson = Lesson::find($id);
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
