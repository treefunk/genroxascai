<?php

use Illuminate\Database\Seeder;
use App\Module;
use App\Lesson;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $modules = Module::all();

        foreach($modules as $key => $module){
            for($x = 0; $x < 6; $x++){
                factory('App\Lesson')->create([
                  'module_id' => $module->id,
                  'order' => $x + 1,
                  'description' => $faker->text(200),
                  'is_open' => true
                ]);
            }
        }

        $lessons = Lesson::all();
        $lessons->each(function ($lesson) {
          $lesson->pretest->is_open = true;
          $lesson->pretest->save();

          $lesson->posttest->is_open = true;
          $lesson->posttest->save();
        });

        $modules = Module::all();
        $modules->each(function ($module) {
          $module->periodicaltest->is_open = true;
          $module->periodicaltest->save();
        });
    }
}
