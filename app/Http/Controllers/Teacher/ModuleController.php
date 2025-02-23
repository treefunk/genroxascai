<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Module;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modules = Module::orderBy('order')->get();

        return view('teachers.modules.index',compact(['modules']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('teachers.modules.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $errors = Module::validateRequest($request);
        if ($errors) {
            return back()->withInput()->withErrors($errors);
        }

        $count = Module::all()->count() + 1;
        $module = Module::create(
            $request->toArray() + ['is_open' => true] + ['order' => $count]
        );

        $module->updateFromRequest($request);
        return redirect()->route('modules.index')->with('success', 'Module saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $module = Module::find($id);
        return view('teachers.modules.show', compact(['module']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $module = Module::find($id);
        return view('teachers.modules.edit', compact(['module']));
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
        $errors = Module::validateRequest($request);
        if ($errors) {
            return back()->withInput()->withErrors($errors);
        }
        $module = Module::find($id);
        if (!$module) {
            return back()->withErrors(['errors' => 'Something went wrong']);
        }
        $module->updateFromRequest($request);
        return redirect()->route('modules.index')->with('success', 'Module updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $module = Module::find($id);
        if ($module) {
            $module->delete();
        }
        return redirect()->route('modules.index')->with('success', 'Module deleted!');
    }
}
