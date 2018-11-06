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
    Route::post('/discharge-invoice-save', 'BackEndController\IPDController@insertDischargeInvoiceDetail');

//route for contact
    Route::resource('/contact', 'BackEndController\ContactController');
    Route::get('/remove-contact/{id}', 'BackEndController\ContactController@destroy');
    Route::post('/update-contact/{id}', 'BackEndController\ContactController@update');
    Route::get('/contact-view', 'BackEndController\ContactController@ViewContact');

    //get total figure in words with AJAX request
    Route::post('/get-total-in-words', 'BackEndController\IPDController@getTotalInWords');
});

Route::group(['middleware' => 'auth', 'prefix' => 'ip-enrollment'], function () {
    Route::resource('/patients', 'BackEndController\IPDController');
    Route::get('/discharge-patient', 'BackEndController\IPDController@Discharge');
    Route::post('/search-patient', 'BackEndController\IPDController@index');

    //Route::get('/patient-history', 'BackEndController\IPDController@DoctorDetails');
    //Route::get('patients/{id}/insert-patient-detail', 'BackEndController\PatientHistoryController@insertPatientDetails');
    Route::get('patients/{id}/insert-doctor-detail', 'BackEndController\IPDController@insertDoctorDetails');
    Route::get('patients/{id}/get-doctor-detail', 'BackEndController\IPDController@getDoctorDetails');
    Route::post('patients/doctor-detail-save', 'BackEndController\IPDController@storeDoctorDetails');
    Route::get('patients/{id}/{pid}/doctor-detail-delete', 'BackEndController\IPDController@deleteDoctorDetails');
    Route::put('patients/{id}/{pid}/doctor-detail-update', 'BackEndController\IPDController@updateDoctorDetails');
//    Route::get('/{id}/patient-history', 'BackEndController\IPDController@generateHistory');

    Route::resource('/patient-report', 'BackEndController\PatientReportController');
    Route::resource('/patient-report', 'BackEndController\PatientReportController');
    Route::get('/patient-search', 'BackEndController\PatientReportController@liveSearch');
    Route::get('{id}/patient-report', 'BackEndController\PatientReportController@createReport');
    Route::get('{id}/print-report', 'BackEndController\PatientReportController@printReport');
//    Route::get('/{id}/patient-report', 'BackEndController\IPDController@generateReport');

    Route::get('/{id}/discharge-patient', 'BackEndController\IPDController@dischargePatient');
    Route::get('/{id}/cancel-discharge', 'BackEndController\IPDController@cancelDischarge');

    Route::resource('/renew/patient', 'BackEndController\RenewIpatientController');
    Route::get('renew/patient', 'BackEndController\RenewIpatientController@liveSearch');
//    Route::resource('/guardian', 'BackEndController\GuardianController');

//    Route::resource('/referrer', 'BackEndController\ReferrerController');

//    Routes with dynamic segments
    Route::get('patients/{id}/remove-patient', 'BackEndController\IPDController@destroy');
    Route::get('/{id}', 'BackEndController\IPDController@show');
    Route::post('/patients/{id}/update-patient', 'BackEndController\IPDController@update');
    Route::get('/{id}/editGuardian', 'BackEndController\IPDController@editGuardian');
    Route::post('/{id}/addGuardian', 'BackEndController\IPDController@addGuardian');
    Route::get('/{id}/editReferrer', 'BackEndController\IPDController@editReferrer');
    Route::post('/{id}/addReferrer', 'BackEndController\IPDController@addReferrer');

    Route::get('/ipatient/{id}/print-invoice', 'BackEndController\IPDController@printInvoice');
    Route::get('/ipatient/{id}/print-invoice/{stat}', 'BackEndController\IPDController@printInvoice');
    Route::get('/ipatient/{id}/print-admit-invoice', 'BackEndController\IPDController@printAdmitInvoice');
    Route::get('/ipatient/{id}/print-admit-invoice/{stat}', 'BackEndController\IPDController@printAdmitInvoice');
    Route::get('/ipatient/{id}/insert-discharge-summary', 'BackEndController\IPDController@insertDischargeSummary');


    /*Route for ipatient bed shift*/
    Route::get('/patients/{id}/edit/{shift}', 'BackEndController\IPDController@edit');

    /*route for adding IPD deposit amount*/
    Route::get('/ipatient/{id}/add-deposit', 'BackEndController\IPDController@addDeposit');
    Route::post('/ipatient/{id}/store-deposit', 'BackEndController\IPDController@storeDeposit');

//    Route::post('create', 'BackEndController\IPDController@store');
//    Route::get('/remove-patient/{id}', 'BackEndController\IPDController@destroy');
//    Route::get('/view-patient/{id}', 'BackEndController\IPDController@show');

//    Route::get('/remove-consulting-fee/{id}', 'BackEndController\ConsultingFeeController@destroy');
//    Route::post('/update-consulting-fee/{id}', 'BackEndController\ConsultingFeeController@update');

});

Route::group(['middleware' => 'auth', 'prefix' => 'emergency'], function () {
    Route::resource('/patient', 'BackEndController\EmergencyController');
    Route::get('/discharge-patient', 'BackEndController\EmergencyController@discharge');
    Route::get('/patient/{id}/print-invoice/{copy}', 'BackEndController\EmergencyController@printEmergencyInvoice');
    Route::get('/patient/{id}/print-invoice-hos', 'BackEndController\EmergencyController@printEmergencyInvoiceHos');
    Route::get('/patient/{id}/edit', 'BackEndController\EmergencyController@edit');
    Route::post('/update-emergency/{id}', 'BackEndController\EmergencyController@update');
    Route::get('/discharge/{id}/discharge', 'BackEndController\EmergencyController@dischargePatient');


});
Route::post('bill-save', 'BackEndController\EmergencyController@insertEmergencyBillingDetail');
Route::get('emergency-invoice/{id}', 'BackEndController\EmergencyController@emergencyInvoice');

Route::get('discharge-without-bill/{id}', 'BackEndController\EmergencyController@skipAndDischarge');
Route::get('live-emergency/patient', 'BackEndController\EmergencyController@liveSearchEmergency');

/*Save patient discharge summary*/
Route::post('patient-discharge-summary-save', 'BackEndController\IPDController@saveDischargeSummary');