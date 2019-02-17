<?php

use Illuminate\Database\Seeder;
use App\Role;

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
            [Role::ADMIN, 'Administrator'],
            [Role::TEACHER, 'Teacher'],
            [Role::STUDENT, 'Student']
        ];

        foreach($roles as $role){
            \App\Role::create([
                'name' => $role[0],
                'display_name' => $role[1]
            ]);
        }
    }
}
