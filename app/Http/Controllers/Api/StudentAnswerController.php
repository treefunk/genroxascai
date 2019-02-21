<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Question;
use App\Choice;

class StudentAnswerController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $questionId = request()->get('question_id');
        $question = Question::find($questionId);
        if (!$question) {
            return response()->json([
                'error' => 'Question not found',
            ], 404);
        }

        $choiceId = request()->get('choice_id');
        $choice = Choice::find($choiceId);
        if (!$choice) {
            return response()->json([
                'error' => 'Choice not found',
            ], 404);
        }

        $test = $question->test;
        if (!$test->canUserTake(Auth::user())) {
            return response()->json([
                'error' => 'You can not answer in this test',
            ], 403);
        }

        $userTest = $test->getStartedTest(Auth::user());
        $studentAnswer = $userTest->saveAnswer($question, $choice);
        return  response()->json($studentAnswer);

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
