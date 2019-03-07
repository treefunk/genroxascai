<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\StudentAnswer;
use App\Test;

class UserTest extends Model
{
    const STATUS_PASSED = 'passed';
    const STATUS_FAILED = 'failed';
    protected $appends = [
        'score',
        'score_status'
    ];


    // =============================================================================
    // QUERIES
    // =============================================================================

    // =============================================================================
    // VALIDATIONS
    // =============================================================================

    // =============================================================================
    // UTILITIES
    // =============================================================================

    public function markFinishedIfExpired()
    {
        if ($this->created_at->addMinutes($this->test->time_limit)->isPast()) {
            $this->finishTest();
        }
    }

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

    public function getScoreAttribute()
    {
        $score = 0;
        if ($this->status == Test::STATUS_FINISHED) {
            $correctChoiceIds = $this->test->getCorrectChoiceIds();
            $studentAnswers = $this->getStudentAnswers();
            foreach ($studentAnswers as $choiceId) {
                if (in_array($choiceId, $correctChoiceIds)) {

                    $score++;
                }
            }

        }
        return $score;
    }

    public function getStudentAnswers()
    {
        $choices = StudentAnswer::where('user_test_id', $this->id)->get()->pluck('choice_id');
        return $choices;
    }

    public function isUserCorrectInQuestion($question)
    {
        $studentAnswer = $this->student_answers->where('question_id', $question->id)->first();
        if ($studentAnswer) {
            $choice = Choice::find($studentAnswer->choice_id);
            return $choice->id === $question->getCorrectChoice()->id;
        }
    }

    public static function removeByUserTest($user, $test)
    {
        self::where('user_id', $user->id)
            ->where('test_id', $test->id)
            ->delete();
    }

    // =============================================================================
    // ADDITIONAL PROPERTIES
    // =============================================================================

    public function isPassed()
    {
        return $this->score >= $this->test->getPassingRate();
    }

    public function getScoreStatusAttribute()
    {
        if ($this->status === Test::STATUS_FINISHED) {
            if ($this->isPassed())
            {
                return self::STATUS_PASSED;
            }else{
                return self::STATUS_FAILED;
            }
        }
        return $this->status;
    }

    // =============================================================================
    // RELATIONSHIPS
    // =============================================================================

    public function test()
    {
        return $this->belongsTo('App\Test');
    }


    public function student_answers()
    {
        return $this->hasMany('App\StudentAnswer');
    }

    // =============================================================================
    // HOOKS / OVERRIDE
    // =============================================================================

}
