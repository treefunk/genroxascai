<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Section;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = Section::all();

        return view('teachers.sections.index', compact(['sections']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('teachers.sections.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $errors = Section::validateRequest($request);
        if ($errors) {
            return back()->withInput()->withErrors($errors);
        }
        $section = Section::createFromData($request->all());
        return redirect()->route('sections.index')->with('success', 'Section saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $section = Section::find($id);
        return view('teachers.sections.show', compact(['section']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $section = Section::find($id);
        return view('teachers.sections.edit', compact(['section']));
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
        $errors = Section::validateRequest($request);
        if ($errors) {
            return back()->withInput()->withErrors($errors);
        }
        $section = Section::find($id);
        if (!$section) {
            return back()->withErrors(['errors' => 'Something went wrong']);
        }
        $section->updateFromRequest($request);
        return redirect()->route('sections.index')->with('success', 'Section updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $section = Section::find($id);
        if ($section) {
            $section->delete();
        }
        return redirect()->route('sections.index')->with('success', 'Section deleted!');
    }
}
