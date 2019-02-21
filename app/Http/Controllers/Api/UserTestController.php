<?php

namespace App\Http\Controllers\Api;

use App\Test;
use App\Lesson;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

class UserTestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $lessonId = request()->get('lesson_id');
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

        return  response()->json($test->user_tests);
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
