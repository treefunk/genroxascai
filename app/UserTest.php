<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\StudentAnswer;
use App\Test;

class UserTest extends Model
{
    const STATUS_PASSED = 'passed';
    const STATUS_FAILED = 'failed';
    // =============================================================================
    // QUERIES
    // =============================================================================

    // =============================================================================
    // VALIDATIONS
    // =============================================================================

    // =============================================================================
    // UTILITIES
    // =============================================================================

    public function finishTest()
    {
        $this->status = Test::STATUS_FINISHED;
        $this->save();
        return $this;
    }

    public static function createFromUserTest($user, $test)
    {
        $userTest = new self();
        $userTest->test_id = $test->id;
        $userTest->user_id = $user->id;
        $userTest->save();
        return $userTest;
    }

    public function saveAnswer($question, $choice)
    {
        return StudentAnswer::saveAnswer($this, $question, $choice);
    }

    public function getScore()
    {
        $score = 0;
        if($this->status == 'finished'){
            $correctChoices = $this->test->getCorrectChoicesById();
            $studentAnswers = $this->getStudentAnswersByTest();

            foreach($studentAnswers as $question_id => $choice_id){
                if(array_key_exists($question_id,$correctChoices) &&
                 in_array($choice_id,$correctChoices[$question_id])){
                     $score++;
                }
            }
            
        }
        return $score;
    }

    public function getStudentAnswersByTest()
    {
        $choices = StudentAnswer::where('user_test_id',$this->id)->get()->pluck('choice_id','question_id');
        return $choices;
    }

    public function getScoreStatus()
    {
        if($this->status == Test::STATUS_FINISHED){
            if($this->getScore() >= $this->test->getPassingRate())
            {
                return self::STATUS_PASSED;
            }else{
                return self::STATUS_FAILED;
            }
        }
        return $this->status;
    }

    // =============================================================================
    // ADDITIONAL PROPERTIES
    // =============================================================================

    // =============================================================================
    // RELATIONSHIPS
    // =============================================================================

    public function test()
    {
        return $this->belongsTo('App\Test');
    }

    // =============================================================================
    // HOOKS / OVERRIDE
    // =============================================================================

}
