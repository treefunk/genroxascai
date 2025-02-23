<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use App\Module;
use App\Section;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = Section::all();
        $users = User::getByRoleName(Role::STUDENT);
        return view('teachers.students.index', compact(['users', 'sections']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections = Section::all();
        return view('teachers.students.create', compact(['sections']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $errors = User::validateRequest($request);
        if ($errors) {
            return back()->withInput()->withErrors($errors);
        }

        User::createFromRequest($request);
        return redirect()->route('students.index')->with('success', 'User saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $modules = Module::all();
        return view('teachers.students.show', compact(['user', 'modules']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $sections = Section::all();
        return view('teachers.students.edit', compact(['user', 'sections']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $errors = User::validateRequest($request);
        if ($errors) {
            return back()->withInput()->withErrors($errors);
        }

        $user = User::find($id);
        if (!$user) {
            return back()->withErrors(['errors' => 'Something went wrong']);
        }

        $user->updateFromRequest($request);
        return redirect()->route('students.index')->with('success', 'User saved!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
        }
        return redirect()->route('students.index')->with('success', 'Student deleted!');
    }
}
