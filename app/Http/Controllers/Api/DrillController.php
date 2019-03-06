<?php


namespace App\Http\Controllers\Api;

use App\Drill;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DrillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lessonId = request()->get('lesson_id');
        $drills = Drill::getByLessonId($lessonId);

        $isOpen = request()->get('is_open');
        if ($isOpen) {
            $drills = $drills->filter(function ($drill, $key) {
                return $drill->is_open;
            });
        }
        return  response()->json($drills);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $drill = Drill::find($id);
      return  response()->json($drill);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
