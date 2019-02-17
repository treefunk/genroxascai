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

Route::prefix('teachers')->middleware('web')->group(function () {

    Route::get('/', 'Teacher\DashboardController@index')->name('dashboard');

    Route::resource('students','Teacher\StudentController');
    Route::resource('modules','Teacher\ModuleController');
    Route::resource('modules.lessons','Teacher\LessonController');

    
    //Test Routes
    Route::resource('lessons.test','Teacher\TestController');
    Route::get('/lessons/{lesson_id}/test/{test_id}/pre-test', 'Teacher\TestController@pretest')->name('pretest');
    Route::get('/lessons/{lesson_id}/test/{test_id}/post-test', 'Teacher\TestController@posttest')->name('posttest');

    
});


//resource routes
// Route::resource('modules','Teacher/ModuleController');
// Route::resource('lessons','LessonController');

Route::get('{path}', function () {
    return view('index');
})->where('path', '(.*)');
