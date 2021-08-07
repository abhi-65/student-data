<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'StudentController@index')->name('index');
    Route::get('add-student', 'StudentController@add')->name('add-student');
    Route::get('edit-student/{id}', 'StudentController@add')->name('edit-student');
    Route::post('save-student-student', 'StudentController@save')->name('save-student');
});

Route::get('login','UserController@login')->name('login');
Route::get('forgot-password','UserController@forgotPassword')->name('forgot-password');
Route::post('check-email','UserController@checkEmail')->name('checkEmail');
Route::post('reset-password','UserController@resetPassword')->name('reset-password');
Route::get('logout','UserController@logout')->name('logout');
Route::get('register','UserController@register')->name('register');
Route::post('save-user','UserController@saveUser')->name('save-user');
Route::post('authenticate','UserController@authenticate')->name('authenticate');