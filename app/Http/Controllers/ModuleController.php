<?php

namespace App\Http\Controllers;

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


        $module_class = ['bg-primary','bg-warning','bg-success','bg-danger'];

        return view('modules.index',compact(['modules','module_class']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('modules.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->all();
        $count = Module::all()->count() + 1;
        $module = Module::create(
            $request->toArray() + ['is_open' => true] + ['order' => $count]
        );
        return redirect(route('modules.index'));
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
        $lesson_class = ['bg-primary','bg-warning','bg-success','bg-danger'];
        return view('modules.show',compact(['module','lesson_class']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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
        $module = Module::find($id);
        $updated = $module->update($request->toArray());
        return response()->json(['status' => $updated]);
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
        $order = $module->order;

        if($deleted = $module->delete()){
            $modules = Module::where('order','>',$order)->decrement('order');
        }

        return response()->json(['status' => $deleted]);
    }
}
