<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\EBook;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use App\Lesson;
use App\Module;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;


class EBooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $eBooks = Ebook::all();
        return view('teachers.ebooks.index', compact('eBooks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('teachers.ebooks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $errors = EBook::validateRequest($request);
        if ($errors) {
            return back()->withInput()->withErrors($errors);
        }
 
        EBook::createFromRequest($request);

        return redirect()->route('ebooks.index')->with('success', 'Ebook saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $eBookId = Route::current()->parameters['ebook'];
        $eBook = EBook::find($eBookId);
        return view('teachers.ebooks.show',['eBook' => $eBook]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $eBookId = Route::current()->parameters['ebook'];
        $eBook = EBook::find($eBookId);
        return view('teachers.ebooks.edit', compact(['eBook']));
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
        $eBookId = Route::current()->parameters['ebook'];
        $errors = EBook::validateRequest($request);
        if ($errors) {
            return back()->withInput()->withErrors($errors);
        }
        $eBook = EBook::find($eBookId);
        if (!$eBook) {
            return back()->withErrors(['errors' => 'Something went wrong']);
        }
        $eBook->updateFromRequest($request);
        return redirect()->route('ebooks.index', [
            'ebook' => $eBookId,
            ])->with('success', 'EBook updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $eBookId = Route::current()->parameters['ebook'];
        $eBook = EBook::find($eBookId);
        if ($eBook) {
            $eBook->delete();
        }
        return redirect()->route('ebooks.index', [
            'ebook' => $eBookId,
            ])->with('success', 'EBook deleted!');
    }
}
