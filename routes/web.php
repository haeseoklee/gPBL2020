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

Route::get('/employees', 'EmployeeController@index');

Route::get('/employees/about', 'EmployeeController@about');

Route::get('/employees/averwt', 'EmployeeController@averwt');

Route::get('/employees/leaveAverwt', 'EmployeeController@leaveAverwt');

Route::get('/assigns', 'AssignController@index');

Route::get('/leaves', 'LeaveController@index');

Route::get('/distance', 'GoogleMapController@index');

Route::get('/distance/address', 'GoogleMapController@address');

Route::get('/api/leaves', 'APIController@index');

Route::post('/api/leaves', 'APIController@filter');

Route::post('/api/averwt', 'APIController@averwt');