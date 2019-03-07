<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:api'], function () {
  Route::post('logout', 'Auth\LoginController@logout');

  Route::get('/user', 'UserController@fetchAuthUser');

  Route::patch('settings/profile', 'Settings\ProfileController@update');
  Route::patch('settings/password', 'Settings\PasswordController@update');
});

Route::group(['middleware' => 'guest:api'], function () {
  Route::post('login', 'Auth\LoginController@login');
  Route::post('register', 'Auth\RegisterController@register');
  Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
  Route::post('password/reset', 'Auth\ResetPasswordController@reset');

  Route::post('oauth/{driver}', 'Auth\OAuthController@redirectToProvider');
  Route::get('oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback')->name('oauth.callback');
});

Route::group(['middleware' => 'auth:api'], function () {
  Route::apiResources([
    'modules' => 'Api\ModuleController',
    'lessons' => 'Api\LessonController',
    'review-materials' => 'Api\ReviewMaterialController',
    'student-review-materials' => 'Api\StudentReviewMaterialController',
    'drills' => 'Api\DrillController',
    'tests' => 'Api\TestController',
    'usertests' => 'Api\UserTestController',
    'questions' => 'Api\QuestionController',
    'choices' => 'Api\ChoiceController',
    'student-answers' => 'Api\StudentAnswerController',
  ]);

});