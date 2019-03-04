<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\UserTest;


class Test extends Model
{
    protected $fillable = [
        'name',
        'passing_grade',
        'type',
        'limit',
        'time_limit'
    ];

    const STATUS_STARTED = 'unfinished';
    const STATUS_FINISHED = 'finished';

    const TYPE_PRETEST = "pretest";
    const TYPE_POSTTEST = "posttest";
    const TYPE_PERIODICALTEST = "periodicaltest";
    const TYPES = [
        self::TYPE_PRETEST,
        self::TYPE_POSTTEST,
        self::TYPE_PERIODICALTEST
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

    public function getUserTests ($user)
    {
        return $this->hasMany('App\UserTest')->where('user_id', $user->id)->get();
    }

    public function start ($user)
    {
        $getStartedTest = $this->getStartedTest($user);
        if ($getStartedTest) {
            return $getStartedTest;
        }
        return UserTest::createFromUserTest($user, $this);
    }

    public function getStartedTest ($user)
    {
        $startedTest = $this->getUserTests($user)
            ->where('status', self::STATUS_STARTED)
            ->first();
        return $startedTest;
    }

    public function hasUserRemainingTry($user)
    {
        if (!$this->limit) {
            return true;
        }
        return $this->getUserTests($user)->count() < $this->limit;
    }

    public function shouldRecommendToTakePreviousTest($user)
    {
        if ($this->lesson->order === 1) {
            return false;
        }

        $previousLesson = $this->lesson->getPrevious();

        $previousTest = $previousLesson->pretest;
        if ($this->type === Test::TYPE_POSTTEST) {
            $previousTest = $previousLesson->posttest;
        }

        $userTest = $user->getHighestUserTestByTest($previousTest);
        if (!$userTest) {
            return true;
        }
        return !$userTest->isPassed() && $previousTest->hasUserRemainingTry($user);
    }

    public function canUserTake ($user)
    {
        $startedTest = $this->getStartedTest($user);
        if ($startedTest) {
            return true;
        }

        return $this->hasUserRemainingTry($user);
    }

    public static function isValidType ($type)
    {
        return in_array($type, self::TYPES);
    }

    public function updateFromRequest ($request) {
        $this->fill($request->all());
        $this->is_open = (bool) $request->get('is_open');
        $this->save();
        return $this;
    }

    public function getCorrectChoicesById() //todo: refactor
    {
        $questions = $this->questions()->with(['choices' => function($q) {
            $q->where('is_correct',1);
        }])->get()->pluck('choices','id');


        $res = [];
        foreach($questions as $question_id => $choices){

            for($x = 0; $x < count($choices); $x++){
                
                if(!isset($res[$question_id])){
                    $res[$question_id] = [];
                }

                $res[$question_id][] = $choices[$x]->id;
            }

        }

        return $res;
    }

    public function getTotalQuestions () {
        return $this->questions()->count();
    }

    public function getPassingRate() {
        return floor(($this->passing_grade * $this->getTotalQuestions())/100); 
    }

    // =============================================================================
    // ADDITIONAL PROPERTIES
    // =============================================================================

    public function getTypeNameAttribute ()
    {
        switch ($this->type) {
            case self::TYPE_PRETEST: return 'Pre-Test';
            case self::TYPE_POSTTEST: return 'Post-Test';
            case self::TYPE_PERIODICALTEST: return 'Periodical-Test';
            default: 'Unknown Test';
        }
    }

    public function questionsWithChoices($json = false)
    {
        $query = $this->questions()->with('choices')->get();

        return $json ? $query->toJson() : $query;
    }

    // =============================================================================
    // RELATIONSHIPS
    // =============================================================================

    public function questions ()
    {
        return $this->hasMany('App\Question');
    }

    public function lesson ()
    {
        return $this->belongsTo('App\Lesson');
    }

    public function module ()
    {
        return $this->belongsTo('App\Module');
    }

    public function choices ()
    {
        return $this->hasManyThrough('App\Choice', 'App\Question');
    }

    // =============================================================================
    // HOOKS / OVERRIDE
    // =============================================================================

}
