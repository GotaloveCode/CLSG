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

    Route::group(['prefix' => 'eois'], function () {
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
    Route::resource('bcps', 'BcpController')->only('index', 'create', 'store', 'show','edit');

    Route::group(['prefix' => 'bcps'], function () {
        Route::post('{bcp}/review', 'BcpController@review')->name('bcps.review');
        Route::post('{bcp}/comment', 'BcpController@comment')->name('bcps.comment');
    });

    Route::resource('erps', 'ErpController')->only('index', 'create', 'store', 'show');

    Route::group(['prefix' => 'erps'], function () {
        Route::post('{erp}/review', 'ErpController@review')->name('erps.review');
        Route::post('{erp}/comment', 'ErpController@comment')->name('erps.comment');
    });

    Route::group(['prefix' => 'reports'],function (){
       Route::get("/monthly-revenue","ReportsController@index");
       Route::get("/checklist","ReportsController@checklist");
       Route::post("/checklist","ReportsController@saveChecklist");
       Route::post("/get-checklist","ReportsController@getChecklist");
    });

    Route::resource('staff', 'StaffController');
});

Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
