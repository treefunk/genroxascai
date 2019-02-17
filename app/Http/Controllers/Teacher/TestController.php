<?php

namespace App\Http\Controllers\Teacher;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
    public function update(Request $request, $lesson_id,$test_id)
    {
        $questions = $request->post('questions') ?? [];
        $test = Test::find($test_id);

        if(Question::saveQuestions($test,$questions)){
            return redirect()->back()->with('success', 'Test Updated!');
        }
        return redirect()->back()->with('error', 'Something went wrong');

    }

    public function pretest($lesson_id,$test_id){
        $questions = Lesson::find($lesson_id)->questionsByType(Test::PRE_TEST);

        return view('teachers.tests.show',compact([
            'questions','lesson_id','test_id'
        ]));
    }


    public function posttest($lesson_id,$test_id){
        $questions = Lesson::find($lesson_id)->questionsByType(Test::POST_TEST);

        return view('teachers.tests.show',compact([
            'questions','lesson_id','test_id'
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
