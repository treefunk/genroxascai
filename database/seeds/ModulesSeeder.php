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
        $x = 1;
        while($x < 7){
            factory('App\Module')->create(['order' => $x]);
            $x++;
        }
    }
}
