<?php

use Illuminate\Database\Seeder;
use App\Module;

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
                  'description' => $faker->text(200)
                ]);
            }
        }
    }
}
