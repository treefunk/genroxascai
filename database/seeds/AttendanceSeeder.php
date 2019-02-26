<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Attendance;
use App\Role;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        
		$users = User::getByRoleName(Role::STUDENT);

		$users->each(function ($user) use ($faker) {
	        $skip = $faker->boolean;
	        if ($skip) {
	            return true;
	        }
	        Attendance::log($user);
		});
    }
}
