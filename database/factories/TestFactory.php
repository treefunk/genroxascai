<?php

use Faker\Generator as Faker;
use App\Test;

$factory->define(App\Test::class, function (Faker $faker) {
    return [
        'lesson_id' => function(){
            return factory('App\Lesson')->create()->id;
        },
        'name' => $faker->cityPrefix,
        'passing_grade' => rand(60,80),
        'type' => ([Test::TYPE_PRETEST, Test::TYPE_POSTTEST])[rand(0,1)]
    ];
});
