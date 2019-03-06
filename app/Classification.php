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
        self::TYPE_OUTSTANDING,
        self::TYPE_VERY_GOOD,
        self::TYPE_GOOD,
        self::TYPE_AVERAGE,
        self::TYPE_NEEDS_IMPROVEMENT,
        self::TYPE_FAILURE
    ];

    private static function _getClassificationByPercentage($percentage)
    {

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

    public static function getByUserModule($user, $module)
    {

        $pretests = collect();
        $posttests = collect();
        $pretests = $module->lessons->map(function ($lesson) use ($user) {
            return $lesson->pretest->getUserTests($user);
        })->flatten(1);


        $posttests = $module->lessons->map(function ($lesson) use ($user) {
            return $lesson->posttest->getUserTests($user);
        })->flatten(1);

        $periodicaltests = $module->periodicaltest->getUserTests($user);

        $tests = collect()->merge($pretests, $posttests, $periodicaltests);

        return self::getClassificationByTests(collect($tests));
    }

    public static function getClassificationByTests($tests)
    {
        $totalScore = $tests->reduce(function ($score, $userTest) {
            return $score + $userTest->score;
        }, 0);

        $totalQuestionCount = $tests->reduce(function ($count, $userTest) {
            $test = Test::find($userTest->test_id);
            return $count + $test->questions->count();
        }, 0);

        if (!$totalScore || !$totalQuestionCount) {
            return self::TYPE_TO_BE_DETERMINED;
        }

        $percentage = $totalScore / $totalQuestionCount * 100;
        return self::_getClassificationByPercentage($percentage);
    }


    public static function getClassificationByUser($user)
    {
        $userTests = $user->user_tests()->where('status', Test::STATUS_FINISHED)->get();

        return self::getClassificationByTests($userTests);

    }
}
