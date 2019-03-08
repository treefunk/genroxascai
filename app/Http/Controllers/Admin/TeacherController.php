<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::getByRoleName(Role::TEACHER)->sortByDesc('created_at');
        return view('admin.teachers.index', compact(['users']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.teachers.create');
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

        User::createFromRequest($request, Role::TEACHER);
        return redirect()->route('teachers.index')->with('success', 'User saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
        return view('admin.teachers.edit', compact(['user']));
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
        return redirect()->route('teachers.index')->with('success', 'User saved!');
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
        return redirect()->route('teachers.index')->with('success', 'Teacher deleted!');
    }
}
