<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class SetupProduction extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $admin = $this->_createFakeData();
        $admin['username'] = 'admin';
        $role = Role::getByName(Role::ADMIN);
        User::create($admin)->attachRole($role);
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
            'username' => $faker->userName,
            'password' => bcrypt('password')
        ];
    }
}
