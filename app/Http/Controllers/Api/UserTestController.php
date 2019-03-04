<?php

namespace App\Http\Controllers\Api;

use App\Test;
use App\Lesson;
use App\Module;
use App\UserTest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

class UserTestController extends Controller
{

    public function _initialValidation()
    {
        $lessonId = request()->get('lesson_id');
        $type = request()->get('type');

        $lesson = Lesson::find($lessonId);
        if (!$lesson) {
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

        if (!$test) {
            return response()->json([
                'error' => 'Something went wrong',
            ], 500);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $this->_initialValidation();
        $lessonId = request()->get('lesson_id');
        $moduleId = request()->get('module_id');
        $lesson = Lesson::find($lessonId);
        $module = Module::find($moduleId);


        $type = request()->get('type');

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
        return  response()->json($test->getUserTests(Auth::user()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->_initialValidation();
        $lessonId = request()->get('lesson_id');
        $moduleId = request()->get('module_id');
        $lesson = Lesson::find($lessonId);
        $module = Module::find($moduleId);
        $type = request()->get('type');


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

        if (!$test->canUserTake(Auth::user())) {
            return response()->json([
                'error' => 'Can not take exam anymore',
            ], 403);
        }

        $user = Auth::user();
        $userTest = $test->start($user);
        return response()->json($userTest);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lesson = Lesson::find($id);
        return  response()->json($lesson);
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
        $this->_initialValidation();

        $finish = request()->get('finish');
        $lessonId = request()->get('lesson_id');
        $moduleId = request()->get('module_id');
        $lesson = Lesson::find($lessonId);
        $module = Module::find($moduleId);
        $type = request()->get('type');

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

        $userTest = $test->getStartedTest(Auth::user());
        if ($finish) {
            $userTest->finishTest();
        }
        return  response()->json($userTest);
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
