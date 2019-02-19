<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Drill extends Model
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

  // =============================================================================
  // ADDITIONAL PROPERTIES
  // =============================================================================

  // =============================================================================
  // RELATIONSHIPS
  // =============================================================================

  public function lesson()
  {
    return $this->belongsTo('App\Lesson');
  }

  // =============================================================================
  // HOOKS / OVERRIDE
  // =============================================================================

}
