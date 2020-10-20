<?php

use App\Http\Controllers\EoiAttachmentController;
use App\Http\Controllers\UserController;
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
    return view('content');
});
Route::get('/preview', function () {
    return view('index');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function () {

    Route::get('wsps/export', 'WspController@import_view')->name('wsps.export');
    Route::post('wsps/import','WspController@import')->name('wsps.import');



    Route::resource('eois', 'EoiController');

    Route::get('eoi/attachments/{filename}', 'EoiAttachmentController@show')->name('eoi.attachments.show');
    Route::delete('eoi/attachments/{attachment}', 'EoiAttachmentController@destroy')->name('eoi.attachments.destroy');
    Route::get('eoi/{eoi}/attachments', 'EoiAttachmentController@index')->name('eoi.attachments');
    Route::post('eoi/{eoi}/attachments','EoiAttachmentController@store')->name('eoi.attachments.store');

    Route::get('eoi/{eoi}/review', 'EoiController@preview')->name('eoi.preview');
    Route::post('eoi/{eoi}/review','EoiController@review')->name('eoi.review');
    Route::post('eoi/{eoi}/comment', 'EoiController@comment')->name('eoi.comment');
    Route::get('eoi/{eoi}/commitment_letter', 'EoiController@commitment_letter')->name('eoi.commitment_letter');
    Route::post('eoi/{eoi}/commitment_letter', 'EoiController@upload_commitment_letter')->name('eoi.commitment_letter.store');


    Route::resource('users', 'UserController')->only('index');
    Route::resource('bcps', 'BcpController');
    Route::get('bcp/{bcp}/review', 'BcpController@preview')->name('bcp.preview');
    Route::post('bcp/{bcp}/review','BcpController@review')->name('bcp.review');
    Route::post('bcp/{bcp}/comment', 'BcpController@comment')->name('bcp.comment');
    Route::get('bcp/{bcp}/commitment_letter', 'BcpController@commitment_letter')->name('bcp.commitment_letter');
    Route::post('bcp/{bcp}/commitment_letter', 'BcpController@upload_commitment_letter')->name('bcp.commitment_letter.store');

//    Route::get('eoi/{eoi}/services', [App\Http\Controllers\EoiController::class, 'services'])->name('eoi.services');
//    Route::post('eoi/{eoi}/services', [App\Http\Controllers\EoiController::class, 'update_services'])->name('eoi.services.update');

});

Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
