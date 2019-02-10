<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeacherController extends UserController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    function __construct(){
        $this->type = "teacher";
    }

}
