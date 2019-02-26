<?php

namespace App\Http\Controllers\Admin;

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

    	$users = User::getByRoleName(Role::TEACHER);

        return view('admin.dashboard', [
        		'users' => $users,
        	]);
    }
}
