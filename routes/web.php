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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('EmpMaster','EmployeeController');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/monPlan', 'EmployeeController@getPlanExpiry')->name('monPlan');
Route::get('/inout', 'EmployeeController@getInoutDuration')->name('inout');
Route::post('/inout', 'EmployeeController@getInoutDurationByDate')->name('inoutByDate');
Route::get('/searchFilter', 'EmployeeController@searchMembers')->name('searchFilter');
Route::get('/searchByFilter', 'EmployeeController@searchByFilter')->name('searchResults');

