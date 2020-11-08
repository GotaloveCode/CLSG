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

Route::get('home', 'HomeController@index')->name('home');
Route::get('clsg', 'HomeController@clsg')->name('clsg');

Route::group(['middleware' => ['auth']], function () {

    Route::group(['prefix' => 'wsps'], function () {
        Route::get('', 'WspController@index')->name('wsps.index');
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


    Route::group(['prefix' => 'reports'], function () {

        //Vulnerable customers
        Route::get("/vulnerable-customer-print/{id}", "ReportsController@printCustomer")->name('vulnerable-customer.print');


        // Performance Scorecard
        Route::get("/performance-score-card-print/{id}", "ReportsController@printCard")->name('performance-score-card.print');

        //Wsp Reporting Monthly
//        Route::get("/wsp-reporting-list","ReportsController@wspIndex")->name('wsp-reporting.list');
        Route::get("/wsp-reporting/print/{id}", "ReportsController@printWsp")->name('wsp-reporting.print');
        Route::get("/wsp-reporting-attachments", "ReportsController@attachmentIndex")->name("wsp-reporting-attachments.list");
//        Route::get("/wsp-reporting-show/{id}","ReportsController@showWsp")->name("wsp-reporting.show");

        //Cslg Calculation
        Route::get("/cslg-calculation-list", "ReportsController@CslgIndex")->name('cslg-calculation.list');
        Route::post("/cslg-calculation", "ReportsController@saveCslg");
        Route::post("/cslg-calculation/approve", "ReportsController@approveCslg");
        Route::get("/cslg-calculation-show/{id}", "ReportsController@showCslg")->name("cslg-calculation.show");
        Route::get("/cslg-calculation/create", "ReportsController@createCslg")->name("cslg-calculation.create");
    });

    Route::resource('wsp-reporting', 'WspReportingController')->except('edit', 'destroy');
    Route::group(['prefix' => 'wsp-reporting'], function () {
        Route::post("/{report}/attachments", "WspReportingAttachmentController@store")->name("wsp-reporting.attachments.store");
        Route::get('/attachments/{filename}', 'WspReportingAttachmentController@show')->name('wsp-reporting.attachments.show');
        Route::delete('/attachments/{attachment}', 'WspReportingAttachmentController@destroy')->name('wsp-reporting.attachments.destroy');
        Route::post('{report}/review', 'WspReportingController@review')->name('wsp-reporting.review');
        Route::post('{report}/comment', 'WspReportingController@comment')->name('wsp-reporting.comment');
    });


    Route::resource('vulnerable-customer', 'VulnerableCustomerReportController')->except('edit', 'destroy');
    Route::group(['prefix' => 'vulnerable-customer'], function () {
        Route::post('{report}/review', 'VulnerableCustomerReportController@review')->name('vulnerable-customer.review');
        Route::post('{report}/comment', 'VulnerableCustomerReportController@comment')->name('vulnerable-customer.comment');
    });

    Route::resource('staff-health', 'StaffReportController')->except('edit', 'destroy');
    Route::group(['prefix' => 'staff-health'], function () {
        Route::post('{report}/review', 'StaffReportController@review')->name('staff-health.review');
        Route::post('{report}/comment', 'StaffReportController@comment')->name('staff-health.comment');
    });

    Route::resource('performance-score-card', 'ScoreCardReportController')->except('edit', 'destroy');
    Route::group(['prefix' => 'performance-score-card'], function () {
        Route::post('{report}/review', 'StaffReportController@review')->name('performance-score-card.review');
        Route::post('{report}/comment', 'StaffReportController@comment')->name('performance-score-card.comment');
    });

    Route::resource('essential-operation', 'EssentialReportController')->except('edit', 'destroy');
    Route::group(['prefix' => 'essential-operation'], function () {
        Route::post('{report}/review', 'EssentialReportController@review')->name('essential-operation.review');
        Route::post('{report}/comment', 'EssentialReportController@comment')->name('essential-operation.comment');
    });

    Route::resource('staff', 'StaffController');
    Route::resource('notifications', 'NotificationController')->only('index', 'update', 'store');

});

Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
