<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Lesson;
use App\Module;
use App\Test;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $lessonId = request()->get('lesson_id');
        $moduleId = request()->get('module_id');
        $module = Module::find($moduleId);
        $lesson = Lesson::find($lessonId);
        if (!$lesson && !$module) {
            return response()->json([
                'error' => 'Lesson not found',
            ], 404);
        }

        $type = request()->get('type');
        if (!Test::isValidType($type)) {
            return response()->json([
                'error' => 'Invalid Type',
            ], 400);
        }

        $test = null;
        if ($type === Test::TYPE_PRETEST) {
            $test = $lesson->pretest;
        }

        if ($type === Test::TYPE_POSTTEST) {
            $test = $lesson->posttest;
        }


        if ($type === Test::TYPE_PERIODICALTEST) {
            $test = $module->periodicaltest;
        }

        if (!$test) {
            return response()->json([
                'error' => 'Something went wrong',
            ], 500);
        }

//        if (!$test->canUserTake(Auth::user())) {
//            return response()->json([
//                'error' => 'Can not take exam anymore',
//            ], 403);
//        }

        // return response()->json($lesson->questionsByType($type));
        return  response()->json($test->questions->shuffle());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
