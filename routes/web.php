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

Route::get('/', function () {
    return view('index');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function () {

    Route::group(['prefix' => 'wsps'], function () {
        Route::get('list', 'WspController@index')->name('wsps.list');
        Route::get('export', 'WspController@import_view')->name('wsps.export');
        Route::post('import', 'WspController@import')->name('wsps.import');
    });

    Route::resource('eois', 'EoiController')->except('edit', 'destroy');

    Route::group(['prefix' => 'eois'], function () {
        Route::get('attachments/{filename}', 'EoiAttachmentController@show')->name('eois.attachments.show');
        Route::delete('attachments/{attachment}', 'EoiAttachmentController@destroy')->name('eois.attachments.destroy');
        Route::get('{eoi}/attachments', 'EoiAttachmentController@index')->name('eois.attachments');
        Route::post('{eoi}/attachments', 'EoiAttachmentController@store')->name('eois.attachments.store');
        Route::post('{eoi}/review', 'EoiController@review')->name('eois.review');
        Route::post('{eoi}/comment', 'EoiController@comment')->name('eois.comment');
        Route::get('{eoi}/commitment_letter', 'EoiController@commitment_letter')->name('eois.commitment_letter');
        Route::post('{eoi}/commitment_letter', 'EoiController@upload_commitment_letter')->name('eois.commitment_letter.store');
    });

    Route::resource('users', 'UserController')->only('index');
    Route::resource('bcps', 'BcpController')->except('edit', 'destroy');

    Route::group(['prefix' => 'bcps'], function () {
        Route::get('attachments/{filename}', 'BcpAttachmentController@show')->name('bcps.attachments.show');
        Route::delete('attachments/{attachment}', 'BcpAttachmentController@destroy')->name('bcps.attachments.destroy');
        Route::post('{bcp}/mgm', 'BcpController@mgm')->name('bcps.mgm');
        Route::get('{bcp}/attachments', 'BcpAttachmentController@index')->name('bcps.attachments');
        Route::post('{bcp}/attachments', 'BcpAttachmentController@store')->name('bcps.attachments.store');
        Route::post('{bcp}/review', 'BcpController@review')->name('bcps.review');
        Route::post('{bcp}/comment', 'BcpController@comment')->name('bcps.comment');
    });

    Route::resource('erps', 'ErpController')->except('edit', 'destroy');

    Route::group(['prefix' => 'erps'], function () {
        Route::get('attachments/{filename}', 'ErpAttachmentController@show')->name('erps.attachments.show');
        Route::delete('attachments/{attachment}', 'ErpAttachmentController@destroy')->name('erps.attachments.destroy');
        Route::get('{erp}/attachments', 'ErpAttachmentController@index')->name('erps.attachments');
        Route::post('{erp}/attachments', 'ErpAttachmentController@store')->name('erps.attachments.store');
        Route::post('{erp}/review', 'ErpController@review')->name('erps.review');
        Route::post('{erp}/comment', 'ErpController@comment')->name('erps.comment');
    });

    Route::group(['prefix' => 'reports'],function (){
        //checklists
        Route::get("/monthly-revenue","ReportsController@index");
        Route::get("/checklist","ReportsController@checklist");
        Route::post("/checklist","ReportsController@saveChecklist");
        Route::get("/checklist-list","ReportsController@checklistIndex")->name("checklist.list");
        Route::get("/checklist-show/{id}","ReportsController@showChecklist")->name("checklist.show");
        Route::get("/monthly-checklist","ReportsController@monthlyChecklist")->name("checklist.monthly-checklist");

        //Essentials
        Route::post("/essential-operation","ReportsController@saveEssential");
        Route::get("/essential-operation-list","ReportsController@essentialIndex")->name('essential-operation.list');
        Route::get("/essential-operation/create","ReportsController@createEssential")->name('essential-operation.create');
        Route::get("/essential-operation-show/{id}","ReportsController@showEssentialOperation")->name('essential-operation.show');//Essentials

        //Vulnerable customers & staff
        Route::post("/vulnerable-customer","ReportsController@saveCustomer");
        Route::get("/vulnerable-customer-list","ReportsController@customerIndex")->name('vulnerable-customer.list');
        Route::get("/vulnerable-customer/create","ReportsController@createCustomer")->name('vulnerable-customer.create');
        Route::get("/vulnerable-customer-show/{id}","ReportsController@showCustomer")->name('vulnerable-customer.show');

        //Wsp Reporting Monthly
        Route::get("/wsp-reporting-list","ReportsController@wspIndex")->name('wsp-reporting.list');
        Route::post("/wsp-reporting","ReportsController@saveWsp");
        Route::get("/wsp-reporting-show/{id}","ReportsController@showWsp")->name("wsp-reporting.show");
        Route::get("/wsp-reporting/create","ReportsController@createWsp")->name("wsp-reporting.create"); //Wsp Reporting Monthly

        //Cslg Calculation
        Route::get("/cslg-calculation-list","ReportsController@CslgIndex")->name('cslg-calculation.list');
        Route::post("/cslg-calculation","ReportsController@saveCslg");
        Route::get("/cslg-calculation-show/{id}","ReportsController@showCslg")->name("cslg-calculation.show");
        Route::get("/cslg-calculation/create","ReportsController@createCslg")->name("cslg-calculation.create");

        //verifications
        Route::get("/monthly-verification","ReportsController@monthlyVerification")->name("reports.monthly-verification");
        Route::get("/verification","ReportsController@verification");
        Route::get("/score","ReportsController@score");
        Route::post("/verification","ReportsController@saveVerification");
        Route::get("/verification-list","ReportsController@verificationIndex")->name("verification.list");
        Route::get("/verification-show/{id}","ReportsController@showVerification")->name("verification.show");

        //report formats
        Route::get("/monthly-report-format","ReportsController@monthlyReportFormat")->name("reports.monthly-report-format");
        Route::get("/report-format","ReportsController@reportFormat");
        Route::get("/report-format-list","ReportsController@formatIndex")->name("report-format.list");
        Route::get("/report-format/{id}","ReportsController@showFormat")->name("report-format.show");
        Route::post("/report-format","ReportsController@saveFormat");
    });

    Route::resource('staff', 'StaffController');

    Route::resource('notifications', 'NotificationController')->only('index', 'update', 'store');

});

Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
