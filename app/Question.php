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

    public static function saveQuestions($test,$questions) //todo: validations/refactor
    {
        $question_ids_existing = $test->questions->pluck('id')->toArray(); // question ids in db
        $question_ids_incoming = collect($questions)->pluck('id')->toArray(); // question ids in request
        
        self::destroy(array_diff($question_ids_existing,$question_ids_incoming)); //delete ids in db not existing in request


        DB::transaction(function() use($questions,$test,&$messageBag) {
            foreach($questions as $question_data){
                $choices = $question_data['choices'];
                unset($question_data['choices']);            


                if($question_data['id'] == null){ // if id is null, do insert

                    // $validations = self::validateQuestion($question_data); 
                    // $messageBag[] = $validations;

                    $question = $test->questions()->create($question_data);

                    foreach($choices as $choice){
                        $question->choices()->create($choice);
                    }

                }else{ //if id is already set, do update
                    
                    $question = self::find($question_data['id']);
                    $question->update($question_data);

                    $choices_ids_existing = $question->choices()->pluck('id')->toArray();
                    $choices_ids_incoming = collect($choices)->pluck('id')->toArray();
                    Choice::destroy(array_diff($choices_ids_existing,$choices_ids_incoming));
                    

                    foreach($choices as $choice){

                        if($choice['id'] == null){
                            $question->choices()->create($choice);
                        }else{
                            Choice::find($choice['id'])->update($choice);
                        }

                    }

                }
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
