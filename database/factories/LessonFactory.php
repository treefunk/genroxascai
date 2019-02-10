<?php

use Faker\Generator as Faker;

$factory->define(App\Lesson::class, function (Faker $faker) {
    return [
        'module_id' => function(){
            return factory('App\Module')->create()->id;
        },
        'name' => $faker->streetName
    ];
});
