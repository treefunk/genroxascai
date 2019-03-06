<?php

use Illuminate\Database\Seeder;
use App\Lesson;
use App\ReviewMaterial;

class ReviewMaterialSeeder extends Seeder
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
            for($x = 0; $x < $faker->numberBetween(1, 6); $x++) {
                $filePath = $this->_getRandomVideo();
                $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
                ReviewMaterial::createFromData([
                    'name' => $faker->name,
                    'description' => $faker->text(300),
                    'is_open' => true
                ], $lesson, $filePath, $fileExtension);
            }
        }
    }

    private function _getRandomVideo()
    {
        $dir = 'database/resources/videos';
        $files = glob($dir . '/*.*');
        $file = array_rand($files);
        return $files[$file];
    }
}
