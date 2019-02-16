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

        // Test Admin
        $admin = $this->_createFakeData();
        $admin['email'] = 'admin@test.com';
        $role = Role::getByName(Role::ADMIN);
        User::create($admin)->attachRole($role);

        // Test Teacher
        $teacher = $this->_createFakeData();
        $teacher['email'] = 'teacher@test.com';
        $role = Role::getByName(Role::TEACHER);
        User::create($teacher)->attachRole($role);

        // Test Student
        $student = $this->_createFakeData();
        $student['email'] = 'student@test.com';
        $role = Role::getByName(Role::STUDENT);
        User::create($student)->attachRole($role);


        // Generated Teachers
        $role = Role::getByName(Role::TEACHER);
       for ($i = 0; $i < 10; $i++) {
            User::create($this->_createFakeData())
            ->attachRole($role);
        }

        // Generated Students
        $role = Role::getByName(Role::STUDENT);
       for ($i = 0; $i < 30; $i++) {
            User::create($this->_createFakeData())
            ->attachRole($role);
        }
    }

    private function _createFakeData() {
        $faker = Faker\Factory::create();
        return [
            'firstname' => $faker->firstname,
            'middlename' => $faker->lastname,
            'lastname' => $faker->lastname,
            'gender' => $faker->randomElement([User::GENDER_MALE, User::GENDER_FEMALE]) ,
            'birthdate' => $faker->date($format = 'Y-m-d', $max = 'now'),
            'address' => $faker->address,
            'contact' => '+639' . $faker->numberBetween(100000000, 999999999),
            'email' => $faker->safeEmail,
            'password' => bcrypt('password')
        ];
    }
}
