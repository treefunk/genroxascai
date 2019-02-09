<?php

use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['admin','Administrator'],
            ['teacher','Teacher'],
            ['student','Student']
        ];

        foreach($roles as $role){
            \App\Role::create([
                'name' => $role[0],
                'display_name' => $role[1]
            ]);
        }
    }
}
