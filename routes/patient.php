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


    Route::resource('/configuration/patient', 'Billing\PatientController');
    Route::post('/update-patient/{id}', 'Billing\PatientController@update');
    Route::get('/configuration/patient/{id}/print-invoice/{copy}', 'Billing\PatientController@printInvoice');
    Route::get('/configuration/patient/{id}/print-invoice-hos/', 'Billing\PatientController@printInvoiceHos');
    Route::get('/configuration/patient/{id}/print-sticker', 'Billing\PatientController@printSticker');
    Route::get('/configuration/print-test-invoice', 'Billing\PatientController@printTestInvoice');
    Route::get('/configuration/patient/{id}/print-test-invoice', 'Billing\PatientController@printTests');
    Route::post('/testslist', 'Billing\PatientController@getTestsList');
    Route::post('/getTestPrice', 'Billing\PatientController@getTestPrice');


//	Route::resource('/revenue/calculation', 'BackEndController\RevenueController');
    Route::get('/enterprise/register/getOffices/{id}/{officeId}', 'Billing\PatientController@officeList');

    Route::get('/patient/data/getDoctorCharge/{id}/{officeId}', 'Billing\PatientController@doctorChargeList');

    //Patient Refunds
    Route::get('/refund-patient/{id}', 'BackEndController\RefundController@refund');
    Route::get('/refund-test-patient/{id}', 'BackEndController\RefundController@testRefund');
    Route::get('/cancel-refund/{id}', 'BackEndController\RefundController@cancelRefund');
    Route::get('test-refund/{id}', 'BackEndController\RefundController@cancelTestRefund');
    Route::get('refunded-patients', 'BackEndController\RefundController@refundedPatients');
    Route::get('refund-view', 'BackEndController\RefundController@refundView');
    Route::get('refund-page/{id}', 'BackEndController\RefundController@refundPage');
    Route::post('/refund-patient', 'BackEndController\RefundController@refundPatient');

    Route::post('/search-opd-patient', 'BackEndController\RefundController@searchOpdPatient');
    Route::post('/search-test-patient', 'BackEndController\RefundController@searchTestPatient');

    /* patient detail */
    Route::get('/patient-detail/{code}', 'Billing\PatientController@getPatientDetail');
    Route::post('/patient-bill-save', 'Billing\PatientController@insertBillingDetail');

    /*Master Data Import/Export*/
    Route::resource('/master-data/backup', 'BackEndController\MasterDataImportExportController');
    Route::get('/master-data/patient/report/{id}', 'BackEndController\MasterDataImportExportController@fiscalYearReport');

    /* News */
    Route::resource('/news', 'News\NewsController');
    Route::get('/deletenews/{id}', 'News\NewsController@destroy');

    /* Doctor Appointment */
    Route::resource('/appointment', 'Appointment\AppointmentController');
    Route::get('/reserve/{docid}/{shiftid}', 'Appointment\AppointmentController@reserve');
    Route::post('/operate_appointment', 'Appointment\AppointmentController@operatereserve');
    Route::post('/searchDoctor', 'Appointment\AppointmentController@searchDoctor');
    Route::get('/appointment/patientlist/{date}', 'Appointment\AppointmentController@patientList');

    Route::get('/emergency/patient', 'Billing\PatientController@emergencyPatient');
    Route::get('configuration/emergency/patient', 'Billing\PatientController@emergencyPatientCreate');

    /*Discount*/
    Route::get('/getdiscount/{dtype}/{id}', 'Billing\PatientController@getDiscountAmount');

    /*test*/
    Route::get('/get-subcategory/{id}', 'Billing\PatientController@getSubCategory');

});