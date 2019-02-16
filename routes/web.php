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

Route::prefix('teachers')->group(function () {

    Route::resource('/modules','Teacher\ModuleController');
    Route::resource('/lessons','Teacher\LessonController');

    Route::get('/', 'Teacher\DashboardController@index')->name('teacher-dashboard');

    //Test Routes
    Route::get('/lessons/{lesson_id}/pre-test', 'Teacher\TestController@pretest')->name('pretest');
    Route::get('/lessons/{lesson_id}/post-test', 'Teacher\TestController@posttest')->name('posttest');

    
});


//resource routes
// Route::resource('modules','Teacher/ModuleController');
// Route::resource('lessons','LessonController');
Route::resource('tests','Teacher/TestController');

Route::get('{path}', function () {
    return view('index');
})->where('path', '(.*)');
