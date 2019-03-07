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

    public function getConsecutiveFailedCount($user)
    {
        $userTests = $this->getUserTests($user);
        $count = 0;
        $userTests->each(function ($userTest) use (&$count) {
            if (!$userTest->isPassed()) {
                $count++;
            } else {
                $count = 0;
            }
        });
        return $count;
    }

    public function getUserTests ($user)
    {
        return $this->hasMany('App\UserTest')
        ->where('user_id', $user->id)
        ->where('test_id', $this->id)
        ->get();
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

    public function getCorrectChoiceIds()
    {
        $choiceIds = [];
        $this->questions->each(function ($question) use (&$choiceIds) {
            $question->choices->each(function ($choice) use (&$choiceIds) {
                if ($choice->is_correct) {
                    array_push( $choiceIds, $choice->id);
                }
            });
        });
        return $choiceIds;
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
        return ceil(($this->passing_grade * $this->getTotalQuestions())/100); 
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
