<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentAnswer extends Model
{
    // =============================================================================
    // QUERIES
    // =============================================================================

    public static function getByUserTest($userTest)
    {
        return self::where('user_id', $userTest->user_id)
        ->where('user_test_id', $userTest->id)->get();
    }

    // =============================================================================
    // VALIDATIONS
    // =============================================================================

    // =============================================================================
    // UTILITIES
    // =============================================================================

    public static function saveAnswer($userTest, $question, $choice)
    {
        self::where('user_id', $userTest->user_id)
            ->where('question_id', $question->id)
            ->delete();

        $studentAnswer = new self();
        $studentAnswer->question_id = $question->id;
        $studentAnswer->user_test_id = $userTest->id;
        $studentAnswer->user_id = $userTest->user_id;
        $studentAnswer->choice_id = $choice->id;
        $studentAnswer->save();
        return $studentAnswer;
    }

    // =============================================================================
    // ADDITIONAL PROPERTIES
    // =============================================================================

    // =============================================================================
    // RELATIONSHIPS
    // =============================================================================

    // =============================================================================
    // HOOKS / OVERRIDE
    // =============================================================================

}
