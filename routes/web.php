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




Route::get('/teacher-dashboard','TeacherMainController@index');

//resource routes
Route::resource('modules','ModuleController');
Route::resource('lessons','LessonController');
Route::resource('tests','TestController');

Route::get('{path}', function () {
    return view('index');
})->where('path', '(.*)');
