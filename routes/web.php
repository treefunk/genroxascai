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
    Route::get('/', 'Teacher\DashboardController@index')->name('teacher-dashboard');
    Route::get('/modules', 'Teacher\ModuleController@index')->name('modules');
    Route::get('/modules/{module_id}/lessons', 'Teacher\LessonController@index')->name('lessons');
    Route::get('/modules/{module_id}/lessons/{lesson_id}', 'Teacher\LessonController@show')->name('lesson');
});


//resource routes
Route::resource('modules','ModuleController');
Route::resource('lessons','LessonController');
Route::resource('tests','TestController');

Route::get('{path}', function () {
    return view('index');
})->where('path', '(.*)');
