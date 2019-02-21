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
        'limit'
    ];

    const STATUS_STARTED = 'started';
    const STATUS_FINISHED = 'finished';

    const TYPE_PRETEST = "pretest";
    const TYPE_POSTTEST = "posttest";
    const TYPES = [
        self::TYPE_PRETEST,
        self::TYPE_POSTTEST
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

    public function canUserTake ($user)
    {
        $startedTest = $this->getStartedTest($user);
        if ($startedTest) {
            return true;
        }

        return $this->getUserTests($user)->count() < $this->limit;
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

    public function getCorrectChoices ()
    {
        $questions = $this->questions()->with(['choices' => function($q) {
            $q->where('is_correct',1);
        }])->get();

        $correctChoices = $questions->map(function($q){
            return $q->only('choices');
        })->flatten(2)->all();

        return $correctChoices;
    }

    // =============================================================================
    // ADDITIONAL PROPERTIES
    // =============================================================================

    public function getTypeNameAttribute ()
    {
        return $this->type == self::TYPE_PRETEST ? 'Pre-Test' : 'Post-Test';
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

    public function choices ()
    {
        return $this->hasManyThrough('App\Choice', 'App\Question');
    }

    // =============================================================================
    // HOOKS / OVERRIDE
    // =============================================================================

}
