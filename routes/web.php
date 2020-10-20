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

    Route::get('wsps/export', 'WspController@import_view')->name('wsps.export');
    Route::post('wsps/import', 'WspController@import')->name('wsps.import');


    Route::resource('eois', 'EoiController')->except('edit', 'destroy');

    Route::get('eoi/attachments/{filename}', 'EoiAttachmentController@show')->name('eoi.attachments.show');
    Route::delete('eoi/attachments/{attachment}', 'EoiAttachmentController@destroy')->name('eoi.attachments.destroy');
    Route::get('eois/{eoi}/attachments', 'EoiAttachmentController@index')->name('eoi.attachments');
    Route::post('eois/{eoi}/attachments', 'EoiAttachmentController@store')->name('eoi.attachments.store');

    Route::post('eoi/{eoi}/review', 'EoiController@review')->name('eoi.review');
    Route::post('eoi/{eoi}/comment', 'EoiController@comment')->name('eoi.comment');
    Route::get('eoi/{eoi}/commitment_letter', 'EoiController@commitment_letter')->name('eoi.commitment_letter');
    Route::post('eoi/{eoi}/commitment_letter', 'EoiController@upload_commitment_letter')->name('eoi.commitment_letter.store');


    Route::resource('users', 'UserController')->only('index');
    Route::resource('bcps', 'BcpController')->only('index', 'create', 'store');
    Route::resource('erps', 'ErpController')->only('index', 'create', 'store');

});

Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
