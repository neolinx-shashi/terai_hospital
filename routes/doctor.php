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

    Route::resource('/configuration/consulting-fee', 'BackEndController\ConsultingFeeController');
    Route::get('/remove-consulting-fee/{id}', 'BackEndController\ConsultingFeeController@destroy');
    Route::post('/update-consulting-fee/{id}', 'BackEndController\ConsultingFeeController@update');


    Route::resource('/configuration/doctor', 'BackEndController\DoctorController');
    Route::get('/remove-doctor/{id}', 'BackEndController\DoctorController@destroy');
    Route::post('/update-doctor/{id}', 'BackEndController\DoctorController@update');


    Route::resource('/configuration/shift-setup', 'BackEndController\DoctorShiftController');
    Route::get('/remove-shift-setup/{id}', 'BackEndController\DoctorShiftController@destroy');
    Route::post('/update-shift-setup/{id}', 'BackEndController\DoctorShiftController@update');


    Route::resource('/nationality-setup', 'BackEndController\NationalityController');
    Route::get('/remove-nationality/{id}', 'BackEndController\NationalityController@destroy');
    Route::post('/update-nationality/{id}', 'BackEndController\NationalityController@update');


    Route::get('configuration/assign/shift/{id}', 'BackEndController\DoctorController@shiftAssign');
    Route::post('/assign/shift/{id}', 'BackEndController\DoctorController@assignShiftToDoctor');

    Route::get('shift/overview/{id}', 'BackEndController\DashboardController@getTodayShiftDoctorList');


//patient renew route
    Route::resource('/renew/patient', 'BackEndController\RenewPatientController');
    Route::get('renew/patient', 'BackEndController\RenewPatientController@liveSearch');
    Route::get('emergency/patient', 'BackEndController\EmergencyController@liveSearchEmergencyData');

    Route::resource('/fiscal-year', 'BackEndController\FiscalYearController');
    Route::get('fiscalYear/changeStatus/{id}', 'BackEndController\FiscalYearController@status');
    Route::get('/remove-fiscal-year/{id}', 'BackEndController\FiscalYearController@destroy');
    Route::post('/update-fiscal-year/{id}', 'BackEndController\FiscalYearController@update');
    Route::get('configuration/doctor/status/{id}', 'BackendController\DoctorController@DoctorStatus');
});
