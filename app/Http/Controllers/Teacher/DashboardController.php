<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;
use App\Module;
use App\Lesson;
use App\ReviewMaterial;
use App\Role;
use App\Test;
use App\Drill;

class DashboardController extends Controller
{
    public function index()
    {
    	$users = User::getByRoleName(Role::STUDENT);
    	$modules = Module::all();
    	$lessons = Lesson::all();
    	$reviewMaterials = ReviewMaterial::all();
    	$drills = Drill::all();
    	$tests = Test::all();

        return view('teachers.dashboard', [
        		'users' => $users,
        		'modules' => $modules,
        		'lessons' => $lessons,
        		'reviewMaterials' => $reviewMaterials,
        		'drills' => $drills,
        		'tests' => $tests,
        	]);
    }
}
