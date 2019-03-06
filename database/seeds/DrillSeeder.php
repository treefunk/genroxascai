<?php

use Illuminate\Database\Seeder;
use App\Lesson;
use App\Drill;

class DrillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $lessons = Lesson::all();

        foreach($lessons as $lesson) {
            for($x = 0; $x < $faker->numberBetween(1, 3); $x++) {
                $filePath = $this->_getRandomVideo();
                $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
                Drill::createFromData([
                    'name' => $faker->name,
                    'is_open' => $faker->boolean
                ], $lesson, $filePath, $fileExtension);
            }
        }
    }

    private function _getRandomVideo()
    {
        $dir = 'database/resources/drills';
        $files = glob($dir . '/*.*');
        $file = array_rand($files);
        return $files[$file];
    }
}
