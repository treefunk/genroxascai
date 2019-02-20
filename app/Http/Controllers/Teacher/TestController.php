<?php

namespace App\Http\Controllers\Teacher;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Test;
use App\Lesson;
use App\Question;
use App\Choice;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
    public function update(Request $request, $lessonId, $testId)
    {
        $testId = Route::current()->parameters['test'];
        $questions = $request->post('questions') ?? [];
        $test = Test::find($testId);

        if (Question::saveQuestions($test,$questions)) {
            return redirect()->back()->with('success', 'Test Updated!');
        }
        return redirect()->back()->with('error', 'Something went wrong');

    }

    public function pretest($lessonId, $testId)
    {
        $lessonId = Route::current()->parameters['lesson'];
        $testId = Route::current()->parameters['test'];
        return $this->test(Test::TYPE_PRETEST, $lessonId, $testId);
    }

    public function posttest($lessonId, $testId)
    {
        $lessonId = Route::current()->parameters['lesson'];
        $testId = Route::current()->parameters['test'];
        return $this->test(Test::TYPE_POSTTEST, $lessonId, $testId);
    }

    public function test($type, $lessonId, $testId)
    {
        $questions = Lesson::find($lessonId)->questionsByType($type);
        $test = Test::find($testId);
        return view('teachers.tests.show',compact([
            'questions',
            'lessonId',
            'testId',
            'test'
        ]));
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
