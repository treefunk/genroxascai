<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $fillable = [
        'name',
        'passing_grade',
        'type'
    ];

    const STATUS_STARTED = 'started';
    const STATUS_FINISHED = 'finished';

    const TYPE_PRETEST = "pretest";
    const TYPE_POSTTEST = "posttest";

    // =============================================================================
    // QUERIES
    // =============================================================================

    // =============================================================================
    // VALIDATIONS
    // =============================================================================

    // =============================================================================
    // UTILITIES
    // =============================================================================


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

    // =============================================================================
    // HOOKS / OVERRIDE
    // =============================================================================

}
