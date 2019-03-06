<?php

namespace App\Http\Controllers\Teacher;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Module;
use App\Role;
use App\Classification;

class AnalysisController extends Controller
{
/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::getByRoleName(Role::STUDENT);


        $classifications =  $users->groupBy('classification');

        $moduleClassification = [];
        $modules = Module::all();

        $modules->each(function ($module) use ($users, &$moduleClassification) {
            $moduleClassification[$module->id] = [
                'module_id' => $module->id,
                'name' => $module->name,
                'good' => 0,
                'bad' => 0,
            ];



           $users->each(function ($user) use ($module, &$moduleClassification) {
                if (
                    Classification::getByUserModule($user, $module) === Classification::TYPE_OUTSTANDING ||
                    Classification::getByUserModule($user, $module) === Classification::TYPE_VERY_GOOD ||
                    Classification::getByUserModule($user, $module) === Classification::TYPE_GOOD ||
                    Classification::getByUserModule($user, $module) === Classification::TYPE_AVERAGE
                    ) {
                    $moduleClassification[$module->id]['good']++;
                }

                if (
                    Classification::getByUserModule($user, $module) === Classification::TYPE_NEEDS_IMPROVEMENT ||
                    Classification::getByUserModule($user, $module) === Classification::TYPE_FAILURE
                    ) {
                    $moduleClassification[$module->id]['bad']++;
                }
            });
        });

        return view('teachers.analysis.index', compact(['users', 'classifications', 'moduleClassification']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
