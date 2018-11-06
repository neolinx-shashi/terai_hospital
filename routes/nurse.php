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


Route::group(['middleware' => 'auth'], function () {
    Route::resource('/configuration/nurse', 'BackEndController\NurseController');
    Route::get('/remove-nurse/{id}', 'BackEndController\NurseController@destroy');
    Route::post('/update-nurse/{id}', 'BackEndController\NurseController@update');

    //Shift Assign
    Route::get('configuration/assign/shift/nurse/{id}', 'BackEndController\NurseController@shiftAssign');
    Route::post('/assign/shift/nurse/{id}', 'BackEndController\NurseController@assignShiftToNurse');
});
