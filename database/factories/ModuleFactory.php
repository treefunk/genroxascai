<?php

use Faker\Generator as Faker;

$factory->define(App\Module::class, function (Faker $faker) {
    return [
      'name' => $faker->domainWord,
      'is_open' => true  
    ];
});
