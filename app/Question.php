<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Choice;
use Illuminate\Support\Facades\Validator;

class Question extends Model
{
    protected $fillable = [
        'text'
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

    // @TODO: validations/refactor
    public static function saveQuestions($test, $questions)
    {
        $question_ids_existing = $test->questions->pluck('id')->toArray(); // question ids in db
        $question_ids_incoming = collect($questions)->pluck('id')->toArray(); // question ids in request

        self::destroy(array_diff($question_ids_existing,$question_ids_incoming)); //delete ids in db not existing in request


        DB::transaction(function() use ($questions, $test) {
            foreach ($questions as $questionData) {
                $choices = $questionData['choices'];
                unset($questionData['choices']);

                $questionId = array_get($questionData, 'id');
                $question = Question::find($questionId);

                // This is a new question, create and continue
                if (!$question) {
                    $question = $test->questions()->create($questionData);
                    foreach ($choices as $choice) {
                        $question->choices()->create($choice);
                    }
                    continue;
                }

                // Update existing question
                $question->update($questionData);

                $incomingChoices = collect($choices);
                $question->choices->each(function ($choice) use ($incomingChoices) {
                    $incomingChoiceIds = $incomingChoices->pluck('id')->toArray();

                    // Delete existing choice if not existing from incoming choices
                    if (!in_array($choice->id, $incomingChoiceIds)) {
                        $choice->delete();
                        return true; // continue
                    }

                    // update existing
                    $matchedChoice = $incomingChoices->first(function ($incomingChoice) use ($choice) {
                        return (int) $incomingChoice['id'] === $choice->id;
                    });
                    $matchedChoice['is_correct'] = (bool) array_get($matchedChoice, 'is_correct'); //fix setting is_correct
                    $choice->update($matchedChoice);
                });

                // Insert new choices (the ones that do not have ids set)
                $incomingChoices->each(function ($incomingChoice) use ($question) {
                    if (array_get($incomingChoice, 'id')) {
                        return true;
                    }
                    $question->choices()->create($incomingChoice);
                });
            }
        });
        return true;
    }

    // =============================================================================
    // ADDITIONAL PROPERTIES
    // =============================================================================

    // =============================================================================
    // RELATIONSHIPS
    // =============================================================================

    public function test()
    {
        return $this->belongsTo('App\Test');
    }

    public function choices()
    {
        return $this->hasMany('App\Choice');
    }

    // =============================================================================
    // HOOKS / OVERRIDE
    // =============================================================================

    public static function boot(){
        parent::boot();

        static::deleting(function($question) {
            $question->choices()->delete();
       });
    }

}
