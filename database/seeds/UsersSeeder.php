<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        // Test Admins
        $users = [];
        $users[] = [
            'firstname' => 'Admin',
            'middlename' => '',
            'lastname' => '',
            'email' => 'admin@test.com',
            'password' => bcrypt('password')
        ];

        $role = Role::getByName(Role::ADMIN)->first();
        foreach($users as $user) {
            User::create($user)
            ->attachRole($role);
        }


        // Test Teachers
        $users = [];
        $users[] = [
            'firstname' => 'Teacher',
            'middlename' => '',
            'lastname' => '',
            'email' => 'teacher@test.com',
            'password' => bcrypt('password')
        ];

        $role = Role::getByName(Role::TEACHER)->first();
        foreach ($users as $user) {
            User::create($user)
            ->attachRole($role);
        }


        // Teachers
        $role = Role::getByName(Role::TEACHER)->first();
       for ($i = 0; $i < 10; $i++) {
            User::create([
                    'firstname' => $faker->firstname,
                    'middlename' => $faker->lastname,
                    'lastname' => $faker->lastname,
                    'email' => $faker->safeEmail,
                    'password' => bcrypt('password')
                ])
            ->attachRole($role);
        }

        // Students
        $role = Role::getByName(Role::STUDENT)->first();
       for ($i = 0; $i < 30; $i++) {
            User::create([
                    'firstname' => $faker->firstname,
                    'middlename' => $faker->lastname,
                    'lastname' => $faker->lastname,
                    'email' => $faker->safeEmail,
                    'password' => bcrypt('password')
                ])
            ->attachRole($role);
        }
    }
}
