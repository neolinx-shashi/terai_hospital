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
    return view('auth.login');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::Resource('/dashboard', 'BackendController\DashboardController');
    Route::resource('/usersetup', 'BackendController\UsersController');
    Route::post('/changepassword/{id}', 'BackendController\UsersController@changePassword');
    Route::get('/remove-user/{id}', 'BackendController\UsersController@destroy');
    Route::get('userstatus/{id}', 'BackendController\UsersController@UserStatus');
    Route::post('/update-user/{id}', 'BackendController\UsersController@update');
});


//route for Billing
Route::resource('/Billing', 'Billing\PatientController');

Route::get('/calendar', function () {
    return view('backendview.calendar.calendar');
});

//route for billing
Route::resource('/billing', 'billing\PatientController', ['except' => 'show']);
Route::get('/billing/{id}/show', [
    'as' => 'billing.homepage.show',
    'uses' => 'billing\PatientController@show'
]);
Route::get('/homepage', 'Billing\PatientController@index');
Route::get('Billing/{id}/confirm', [
    'as' => 'Billing.confirm',
    'uses' => 'Billing\PatientController@confirm'
]);
Route::get('/opdbill', 'Billing\PatientController@create');
Route::get('/opdbill/{id}', 'Billing\PatientController@doctorList');

Route::get('/Admin', 'Admin\PatientController@index');
Route::resource('/Admin', 'Admin\PatientController');
Route::get('/Admin/{id}/confirm', [
    'as' => 'Billing.delete',
    'uses' => 'Admin\PatientController@confirm'
]);


Route::resource('/department', 'Admin\DepartmentController');
Route::get('/remove-department/{id}', 'Admin\DepartmentController@destroy');
Route::post('/update-department/{id}', 'Admin\DepartmentController@update');







