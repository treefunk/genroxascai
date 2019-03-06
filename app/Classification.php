<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Test;

class Classification extends Model
{

    const TYPE_OUTSTANDING = "outstanding";
    const TYPE_VERY_GOOD = "very good";
    const TYPE_GOOD = "good";
    const TYPE_AVERAGE = "average";
    const TYPE_NEEDS_IMPROVEMENT = "needs improvement";
    const TYPE_FAILURE = "failure";
    const TYPE_TO_BE_DETERMINED = "to be determined";

    const TYPES = [
        self::TYPE_PRETEST,
        self::TYPE_POSTTEST,
        self::TYPE_PERIODICALTEST
    ];


    public static function getClassificationByUser($user)
    {
        $userTests = $user->user_tests()->where('status', Test::STATUS_FINISHED)->get();

        $totalScore = $userTests->reduce(function ($score, $userTest) {
            return $score + $userTest->score;
        }, 0);

        $totalQuestionCount = $userTests->reduce(function ($count, $userTest) {
            $test = Test::find($userTest->test_id);
            return $count + $test->questions->count();
        }, 0);

        if (!$totalScore || !$totalQuestionCount) {
            return self::TYPE_TO_BE_DETERMINED;
        }

        $percentage = $totalScore / $totalQuestionCount * 100;

        if ($percentage >= 95) {
            return self::TYPE_OUTSTANDING;
        }

        if ($percentage >= 89) {
            return self::TYPE_VERY_GOOD;
        }

        if ($percentage >= 82) {
            return self::TYPE_GOOD;
        }

        if ($percentage >= 79) {
            return self::TYPE_AVERAGE;
        }

        if ($percentage >= 75) {
            return self::TYPE_NEEDS_IMPROVEMENT;
        }

        return self::TYPE_FAILURE;
    }
}
