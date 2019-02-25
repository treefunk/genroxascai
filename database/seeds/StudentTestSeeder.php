<?php

use Illuminate\Database\Seeder;

use App\Test;
use App\User;
use App\Role;
use App\UserTest;
use App\StudentAnswer;

class StudentTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tests = Test::all();
        $users = User::getByRoleName(Role::STUDENT);
        $tests->each(function ($test) use ($users) {
        	if ($test->is_open && $test->lesson->is_open && $test->lesson->module->is_open) {
        		$users->each(function ($user) use ($test) {
        			$this->_takeTest($user, $test);
        		});
        	}
        });
    }

    private function _takeTest($user, $test)
    {
    	$faker = Faker\Factory::create();

    	$userTest = UserTest::createFromUserTest($user, $test);
    	$willFinish = $faker->boolean(75);
    	
    	$test->questions->each(function ($question) use ($userTest, $user) {
    		$choice = $question->choices->random();
    		StudentAnswer::saveAnswer($userTest, $question, $choice);
    	});

    	if ($willFinish) {
    		$userTest->finishTest();
    	}
    }
}
