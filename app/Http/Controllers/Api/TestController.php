<?php

namespace App\Http\Controllers\Api;

use App\Test;
use App\Lesson;
use App\Module;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
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

        $lesson = Lesson::find($lessonId);
        if (!$lesson && !$moduleId) {
            return response()->json([
                'error' => 'Lesson not found',
            ], 404);
        }

        $module = Module::find($moduleId);
        if (!$moduleId) {
            return response()->json([
                'error' => 'Module not found',
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

        if ($type === Test::TYPE_PERIODICALTEST) {
            $test = $module->periodicaltest;
        }

        if ($type === Test::TYPE_POSTTEST) {
            $test = $lesson->posttest;
            if ($test->shouldRecommendToTakePreviousTest(Auth::user())) {
                $test['flag_recommended_to_take_previous_test'] = true;
            }
        }

        if (!$test) {
            return response()->json([
                'error' => 'Something went wrong',
            ], 500);
        }

        return  response()->json($test);
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
