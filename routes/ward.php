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


Route::group(['middleware' => 'auth', 'prefix' => 'ward'], function ()
{
    Route::resource('/ward-details', 'BackEndController\WardController');
    Route::resource('/room', 'BackEndController\RoomController');
    Route::resource('/bed', 'BackEndController\BedController');
    Route::get('ward-detail/{id}', 'BackEndController\WardController@destroy');
    Route::post('ward-details/{id}', 'BackEndController\WardController@update');
    Route::get('delete-room/{id}', 'BackEndController\RoomController@destroy');
    Route::post('update-room/{id}', 'BackEndController\RoomController@update');
    Route::get('delete-bed/{id}', 'BackEndController\BedController@destroy');
    Route::post('update-bed/{id}', 'BackEndController\BedController@update');
    Route::get('/getRooms/{id}/{officeId}', 'BackEndController\BedController@roomList');
    Route::get('/private/getRooms/{id}/{officeId}', 'BackEndController\BedController@privateRoomList');
    Route::get('/getBeds/{id}/{officId}', 'BackEndController\BedController@bedList');
    Route::get('/get-ward/{id}', 'BackEndController\RoomController@getWard');

    //get ward name to generate room type


//    Routes with dynamic segments
//    Route::get('/{id}', 'BackEndController\IPDController@destroy');
//    Route::get('/{id}', 'BackEndController\IPDController@show');



//    Route::post('create', 'BackendController\IPDController@store');
//    Route::get('/remove-patient/{id}', 'BackendController\IPDController@destroy');
//    Route::get('/view-patient/{id}', 'BackendController\IPDController@show');

//    Route::get('/remove-consulting-fee/{id}', 'BackendController\ConsultingFeeController@destroy');
//    Route::post('/update-consulting-fee/{id}', 'BackendController\ConsultingFeeController@update');

});