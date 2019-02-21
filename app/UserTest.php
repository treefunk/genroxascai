<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\StudentAnswer;
use App\Test;

class UserTest extends Model
{
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
