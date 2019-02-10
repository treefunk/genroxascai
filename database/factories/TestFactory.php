<?php

use Faker\Generator as Faker;

$factory->define(App\Test::class, function (Faker $faker) {
    return [
        'lesson_id' => function(){
            return factory('App\Lesson')->create()->id;
        },
        'name' => $faker->cityPrefix,
        'passing_grade' => rand(60,80),
        'type' => (['pre_test','post_test'])[rand(0,1)]
    ];
});
