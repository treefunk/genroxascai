<?php

use Illuminate\Database\Seeder;

use App\Lesson;
use App\Question;
use App\Module;

class QuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modules = Module::all();
        $modules->each(function ($module) {
            $module->lessons->each(function ($lesson) {
                Question::saveQuestions($lesson->pretest, $this->_createQuestions());
                Question::saveQuestions($lesson->posttest, $this->_createQuestions());
            });
            Question::saveQuestions($module->periodicaltest, $this->_createQuestions());
        });
    }

    private function _createQuestions()
    {
        $faker = Faker\Factory::create();
        $questions = [];
        for ($i = 0; $i <= $faker->numberBetween(1, 4); $i++) {

            $choices = [];
            $choices[] = $this->_createChoice(true);
            for ($cnt = 0; $cnt <= $faker->numberBetween(1, 3); $cnt++) {
                $choices[] = $this->_createChoice();
            }

            $questions[] = [
                'text' => $faker->text,
                'choices' => $choices
            ];
        }
        return $questions;
    }
    private function _createChoice($forceCorrect = false)
    {
        $faker = Faker\Factory::create();
        return [
            'text' => $faker->sentence,
            'is_correct' => $forceCorrect ? true : $faker->boolean(10)
        ];
    }
}
