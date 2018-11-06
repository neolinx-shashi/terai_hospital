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

    if (Auth::check()) {
        return redirect('/dashboard');
    } else {
        return view('auth.login');
    }
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::Resource('/dashboard', 'BackEndController\DashboardController');
    Route::resource('/usersetup', 'BackEndController\UsersController');
    Route::post('/changepassword', 'BackEndController\UsersController@changePassword');
    Route::get('/remove-user/{id}', 'BackEndController\UsersController@destroy');
    Route::get('userstatus/{id}', 'BackEndController\UsersController@UserStatus');
    Route::post('/update-user/{id}', 'BackEndController\UsersController@update');
    Route::post('/resetPassword/{id}', 'BackEndController\UsersController@userPasswordReset');
    Route::get('my-profile/{id}', 'BackEndController\UsersController@myProfile');

    //route for Billing
    Route::resource('/Billing', 'Billing\PatientController');

    Route::get('/calendar', function () {
        return view('backendview.calendar.calendar');
    });

//route for billing
    Route::resource('/billing', 'billing\PatientController');
    Route::get('/homepage', 'Billing\PatientController@index');
    Route::get('/opdbill', 'Billing\PatientController@create');
    Route::get('/opdbill/{id}', 'Billing\PatientController@doctorList');
    Route::get('Billing/{id}/confirm', [
        'as' => 'Billing.confirm',
        'uses' => 'Billing\PatientController@confirm'
    ]);
    Route::get('/homepage', 'Billing\PatientController@index');
    Route::get('/configuration/patient/create/{id}', 'Billing\PatientController@doctorList');
    Route::get('/billing/dailyReport/{id}', 'BackEndController\ReportController@dailyReport');
    Route::get('/billing/total-patients-today/{id}', 'Billing\PatientController@totalPatientsToday');

//route for admin
    Route::get('/Admin', 'Admin\PatientController@index');
    Route::resource('/Admin', 'Admin\PatientController');
    Route::get('/Admin/{id}/confirm', [
        'as' => 'Billing.delete',
        'uses' => 'Admin\PatientController@confirm'
    ]);

//route for department
    Route::resource('/department', 'Admin\DepartmentController');
    Route::get('/remove-department/{id}', 'Admin\DepartmentController@destroy');
    Route::post('/update-department/{id}', 'Admin\DepartmentController@update');

//route for service charge
    Route::resource('/service-charge', 'BackEndController\ServiceChargeController');
    Route::get('/remove-service-charge/{id}', 'BackEndController\ServiceChargeController@destroy');
    Route::post('/update-service-charge/{id}', 'BackEndController\ServiceChargeController@update');

//Master Data Import/Export
    Route::resource('/data/import/export', 'BackEndController\MasterDataImportExportController');

//tree view category
    Route::get('category-tree-view', ['uses' => 'BackEndController\CategoryController@manageCategory']);
    Route::post('add-category', ['as' => 'add.category', 'uses' => 'BackEndController\CategoryController@addCategory']);
    Route::get('/category-check/{id}/{categoryId}', 'BackEndController\CategoryController@CategoryCheck');

    Route::post('add-subcategory', ['as' => 'add.subcategory', 'uses' => 'BackEndController\CategoryController@addSubCategory']);
    Route::get('/manageSubcategory/{cid}', 'BackEndController\CategoryController@manageSubcategory');
    Route::post('/update-subcategory', 'BackEndController\CategoryController@updateSubcategory');

    Route::post('add-test', ['as' => 'add.test', 'uses' => 'BackEndController\CategoryController@addTest']);
    Route::get('/manageTests/{sid}', 'BackEndController\CategoryController@manageTests');
    Route::get('/get-consulting-doctor/{sid}', 'BackEndController\CategoryController@getConsultingDoctor');
    Route::get('/manageSubcategoryWithTests/{cid}', 'BackEndController\CategoryController@getSubcategoryWithTests');
    Route::get('/getTestDetail/{tid}', 'BackEndController\CategoryController@getTestDetail');
    Route::get('/getSubDetail/{tid}', 'BackEndController\CategoryController@getSubDetail');
    Route::post('/update-tests', 'BackEndController\CategoryController@updateTest');

//search
    Route::get('dashboard/search/{id}', 'BackEndController\SearchController@dashboardSearch');
    Route::get('revenue/search/{id}', 'BackEndController\SearchController@dashboardSearch');

// route for account
    Route::get('/billing-report', 'Account\AccountController@billingReport');
    Route::get('/monthly-report', 'Account\AccountController@monthlyReport');
    Route::get('/yearly-report', 'Account\AccountController@yearlyReport');
    Route::post('/report-by-date', 'Account\AccountController@dateReport');
    Route::get('/doctor-report', 'Account\AccountController@doctorReport');
    Route::get('/pathology-report', 'Account\AccountController@pathologyReport');
//Route::post('/operate-pathology-report', 'Account\AccountController@operatePathologyReport');
    Route::post('/operate-pathology-report', 'Account\AccountController@operatePathologyReportByBillNumber');
    Route::get('/general-report', 'Account\AccountController@generalReport');
    Route::post('/operate-general-report', 'Account\AccountController@operateGeneralReport');
    /*Route for IPD report*/
    Route::get('/ipd-report', 'Account\AccountController@IPDReport');
    Route::post('/generate-ipd-report', 'Account\AccountController@GenerateIPDReport');
    Route::get('/ipd-deposit-report', 'Account\AccountController@IPDDepostiReport');
    Route::post('/generate-ipd-deposit-report', 'Account\AccountController@GenerateIPDDepositReport');

//route for revenue
    Route::get('/revenue/calculation', 'BackEndController\CalculationController@dailyRevenue');
    Route::get('/revenue/calculation/this-week', 'BackEndController\CalculationController@weeklyRevenue');
    Route::get('/revenue/calculation/this-month', 'BackEndController\CalculationController@monthlyRevenue');
    Route::get('/revenue/calculation/this-year', 'BackEndController\CalculationController@yearlyRevenue');
    Route::post('/revenue/calculation/by-date', 'BackEndController\CalculationController@revenueByDate');
    Route::get('/revenue/detail-user/{id}/{from}/{to}', 'BackEndController\CalculationController@getUserRevenueDetail');
    Route::get('/revenue/total', 'BackEndController\CalculationController@totalRevenue');
    Route::post('/operateTotalRevenue', 'BackEndController\CalculationController@operateTotalRevenue');

//route for test print
    Route::get('/test-invoice/{id}/{data}', 'Billing\PatientController@testInvoicePrint');
    Route::get('/test-invoice/{id}/{data}/hos', 'Billing\PatientController@testInvoicePrintHos');
    Route::get('/test-invoice-list', 'Billing\PatientController@testpatientlist');
    Route::post('/search-test-invoice-list', 'Billing\PatientController@searchTestpatientlist');

    Route::any('/search', 'BackEndController\DashboardController@globalSearch');

    Route::resource('/emergency-fee', 'BackEndController\EmergencyFeeController');
    Route::get('emergency-fee/changeStatus/{id}', 'BackEndController\EmergencyFeeController@status');
    Route::get('/remove-emergency-fee/{id}', 'BackEndController\EmergencyFeeController@destroy');
    Route::post('/update-emergency-fee/{id}', 'BackEndController\EmergencyFeeController@update');

    /*Route for IPDAdmissionCharge*/
    Route::resource('/admission-charge', 'BackEndController\IPDAdmissionChargeController');
    Route::get('/admission-charge/change-status/{id}', 'BackEndController\IPDAdmissionChargeController@status');
    Route::get('/remove-admission-charge/{id}', 'BackEndController\IPDAdmissionChargeController@destroy');
    Route::post('/update-admission-charge/{id}', 'BackEndController\IPDAdmissionChargeController@update');


    Route::get('/re-admit/patient/{id}', 'BackEndController\ReadmitController@reAdmitPatient');
    Route::post('/re-admit/patient/opd/{id}', 'BackEndController\ReadmitController@readmitOpdSection');
    Route::post('/emergency/patient/emergency/{id}', 'BackEndController\ReadmitController@readmitEmergencyPatient');
    Route::post('/ipd/patient/ipd/{id}', 'BackEndController\ReadmitController@readmitIpdPatient');

    Route::get('revenue/report/opd/{data}', 'BackEndController\CalculationController@reportGenerateforOpd');
    Route::get('revenue/report/emergency/{data}', 'BackEndController\CalculationController@reportGenerateforEmergency');
    Route::get('revenue/report/ipd/{data}', 'BackEndController\CalculationController@reportGenerateforIpd');
    Route::get('revenue/report/test/{data}', 'BackEndController\CalculationController@reportGenerateforTest');

    Route::get('revenue/report/custom-search/opd/{data}/{from}/{to}', 'BackEndController\CalculationController@generateReportBycustomOpd');


    Route::get('revenue/report/custom-emergency/by-date/{data}/{from}/{to}', 'BackEndController\CalculationController@generateReportBycustomEmergency');

    Route::get('revenue/report/custom-search/ipd/{data}/{from}/{to}', 'BackEndController\CalculationController@generateReportBycustomIpd');

    Route::get('revenue/report/custom-search/test/{data}/{from}/{to}', 'BackEndController\CalculationController@generateReportBycustomTest');


    Route::get('/revenue/by-user', 'BackEndController\CalculationController@gotoUserRevenue');
    Route::post('/revenue/by-user', 'BackEndController\CalculationController@getUserRevenue');

    Route::post('/edit-category', 'BackEndController\CategoryController@editCategory');
    Route::get('/delete-category/{id}', 'BackEndController\CategoryController@deleteCategory');

    Route::post('/operate-doctor-report', 'Account\AccountController@operateDoctorReport');

    Route::get('refund/patient/opd/today', 'BackEndController\RefundController@generateReportToday');
    Route::get('refund/patient/fiscal-year/{id}', 'BackEndController\RefundController@generateReportByFiscalYear');


    Route::get('refund/test-patient/test/today', 'BackEndController\RefundController@generateTestReportToday');
    Route::get('refund/test-patient/fiscal-year/{id}', 'BackEndController\RefundController@generateTestReportByFiscalYear');

//Route for Discount and Discount Type
    Route::resource('/discount-type', 'BackEndController\DiscountTypeController');
    Route::resource('/discount', 'BackEndController\DiscountController');

    //Route for IPD Doctor Charge Setup
    Route::resource('/doctor-charge', 'BackEndController\DoctorChargeController');
    Route::get('/remove-doctor-charge/{id}', 'BackEndController\DoctorChargeController@destroy');
    Route::post('/update-doctor-charge/{id}', 'BackEndController\DoctorChargeController@update');

    //get doctor charge with doctor charge type
    Route::get('/get-doctor-charge/{id}', 'BackEndController\DoctorChargeController@getDoctorCharge');

    /* Date deposit report */
    Route::get('/deposit-report-date', 'Account\AccountController@dateDepositReport');
    Route::post('/operate-date-deposit-report', 'Account\AccountController@operateDateDepositReport');

    /* date discharge report */
    Route::get('/discharge-report-date', 'Account\AccountController@dateDischargeReport');
    Route::post('/operate-date-discharge-report', 'Account\AccountController@operateDateDischargeReport');

    /* patient history */
    Route::get('/patient-history', 'BackEndController\HistoryController@index');
    Route::post('/patient-history-detail', 'BackEndController\HistoryController@searchDetail');
});