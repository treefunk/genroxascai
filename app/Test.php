<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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

    // =============================================================================
    // QUERIES
    // =============================================================================

    // =============================================================================
    // VALIDATIONS
    // =============================================================================

    // =============================================================================
    // UTILITIES
    // =============================================================================

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

    // =============================================================================
    // HOOKS / OVERRIDE
    // =============================================================================

}
