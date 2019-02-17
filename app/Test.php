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

    const PRE_TEST = "pre_test";
    const POST_TEST = "post_test";

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

    // =============================================================================
    // RELATIONSHIPS
    // =============================================================================

    public function questions()
    {
        return $this->hasMany('App\Question');
    }

    // =============================================================================
    // HOOKS / OVERRIDE
    // =============================================================================

}
