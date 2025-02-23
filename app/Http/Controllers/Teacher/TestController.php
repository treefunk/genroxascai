<?php

namespace App\Http\Controllers\Teacher;

use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Test;
use App\Lesson;
use App\Module;
use App\Question;
use App\Choice;
use App\User;

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

        $test->updateFromRequest($request);

        if (Question::saveQuestions($test, $questions)) {
            return redirect()->back()->with('success', 'Test Updated!');
        }
        return redirect()->back()->with('error', 'Something went wrong');

    }

    public function pretest()
    {
        $lessonId = Route::current()->parameters['lesson'];
        $testId = Route::current()->parameters['test'];
        return $this->_test(Test::TYPE_PRETEST, $lessonId, $testId);
    }

    public function posttest()
    {
        $lessonId = Route::current()->parameters['lesson'];
        $testId = Route::current()->parameters['test'];
        return $this->_test(Test::TYPE_POSTTEST, $lessonId, $testId);
    }


    public function periodicaltest()
    { 
        
        $moduleId = Route::current()->parameters['module'];
        $testId = Route::current()->parameters['test'];
        return $this->_test(Test::TYPE_PERIODICALTEST, null, $testId, $moduleId);
    }

    private function _test($type, $lessonId, $testId, $moduleId = null)
    {
        $questions = null;
        if ($lessonId) {
            $questions = Lesson::find($lessonId)->questionsWithChoicesByType($type);
        }

        if ($moduleId) {
            $questions = Module::find($moduleId)->periodicaltest->questionsWithChoices();
        }

        $test = Test::find($testId);
        return view('teachers.tests.show',compact([
            'questions',
            'lessonId',
            'testId',
            'test'
        ]));
    }

    public function testscores()
    {
        $testId = Route::current()->parameters['test'];
        $test = Test::find($testId);
        $users = User::getByRoleName(Role::STUDENT);

        // dd($users);

        return view('teachers.tests.scores',compact([
            'test',
            'users'
        ]));
    }

    public function testStudentAnswers()
    {
        $testId = Route::current()->parameters['test'];
        $test = Test::find($testId);
        $users = User::getByRoleName(Role::STUDENT);

        return view('teachers.tests.student-answers',compact([
            'test',
            'users'
        ]));
    }

    public function testCorrectAnswers()
    {
        $testId = Route::current()->parameters['test'];
        $test = Test::find($testId);
        // $testAnswers = $test->getCorrectAnswersWithQuestions();
        $testAnswers = $test->questionsWithChoices();

        return view('teachers.tests.answers', compact([
            'test',
            'testAnswers'
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
