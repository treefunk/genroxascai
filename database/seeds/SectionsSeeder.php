<?php

use Illuminate\Database\Seeder;

use App\Section;
use App\User;
use App\Role;

class SectionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sectionNames = [
        	'Section A',
        	'Section B',
        	'Section C',
        ];

        foreach ($sectionNames as $sectionName) {
        	$section = Section::createFromData([
        			'name' => $sectionName
        		]);

        }

        $sections = Section::all();

    	$users = User::getByRoleName(Role::STUDENT);
        $users->each(function ($user) use ($sections) {
        	$user->saveSection($sections->random());
        });

    }
}
