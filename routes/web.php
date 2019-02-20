<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use \Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Facades\Route;


// =============================================================================
// BACKEND ROUTES
// =============================================================================
if (Auth::user() &&  Auth::user()->is_teacher) {

    Route::middleware(['web', 'teacher'])->group(function () {

        Route::get('/dashboard', 'Teacher\DashboardController@index')->name('dashboard');

        Route::resource('students','Teacher\StudentController');
        Route::resource('modules','Teacher\ModuleController');
        Route::resource('modules.lessons','Teacher\LessonController');
        Route::resource('modules.lessons.review-materials','Teacher\ReviewMaterialsController');

        //Test Routes
        Route::resource('modules.lessons.test','Teacher\TestController');
        Route::get('/modules/{module}/lessons/{lesson}/test/{test}/pretest', 'Teacher\TestController@pretest')->name('pretest');
        Route::get('/modules/{module}/lessons/{lesson}/test/{test}/posttest', 'Teacher\TestController@posttest')->name('posttest');

    });
}

// =============================================================================
// SPA ROUTES
// =============================================================================

//resource routes
// Route::resource('modules','Teacher/ModuleController');
// Route::resource('lessons','LessonController');

Route::get('{path}', function () {
    return view('index');
})->where('path', '(.*)');
