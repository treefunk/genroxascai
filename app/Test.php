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

    public static function isValidType($type)
    {
        return in_array($type, self::TYPES);
    }

    public function updateFromRequest($request) {
        $this->fill($request->all());
        $this->is_open = (bool) $request->get('is_open');
        $this->save();
        return $this;
    }

    // =============================================================================
    // ADDITIONAL PROPERTIES
    // =============================================================================

    public function getTypeNameAttribute()
    {
        return $this->type == self::TYPE_PRETEST ? 'Pre-Test' : 'Post-Test';
    }

    // =============================================================================
    // RELATIONSHIPS
    // =============================================================================

    public function questions()
    {
        return $this->hasMany('App\Question');
    }

    public function lesson()
    {
        return $this->belongsTo('App\Lesson');
    }

    public function user_tests()
    {
        return $this->hasMany('App\UserTest')->where('user_id', Auth::user()->id);
    }

    // =============================================================================
    // HOOKS / OVERRIDE
    // =============================================================================

}
