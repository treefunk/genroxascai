<?php

use Illuminate\Database\Seeder;

class ModulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $x = 1;
        while($x < 3){
            factory('App\Module')->create([
              'order' => $x,
              'description' => $faker->text(200),
              'is_open' => true
            ]);
            $x++;
        }
    }
}
