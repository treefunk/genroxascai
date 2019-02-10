<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_types = [
            'admin' => 'admin',
            'teacher' => 'teacher_test',
            'student' => 'student_test'
        ];

        foreach($user_types as $role => $name){
            $user = \App\User::create([
                'name' => $name, 
                'email' => "{$name}@test.com",
                'password' => bcrypt('password')
            ]);

            $user->attachRole(\App\Role::where('name',$role)->first());
        }

    }
}
