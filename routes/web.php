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


    Route::get('eois', 'EoiController@list_view');
    Route::get('eois/list', 'EoiController@index')->name('eois.list');
    Route::get('eoi', 'EoiController@create');
    Route::post('eoi', 'EoiController@store')->name('eoi.store');

    Route::get('eoi/attachments/{filename}', 'EoiAttachmentController@show')->name('eoi.attachments.show');
    Route::delete('eoi/attachments/{attachment}', 'EoiAttachmentController@destroy')->name('eoi.attachments.destroy');
    Route::get('eoi/{eoi}/attachments', 'EoiAttachmentController@index')->name('eoi.attachments');
    Route::post('eoi/{eoi}/attachments','EoiAttachmentController@store')->name('eoi.attachments.store');

    Route::get('eoi/{eoi}/review', 'EoiController@preview')->name('eoi.preview');
    Route::post('eoi/{eoi}/review','EoiController@review')->name('eoi.review');
    Route::post('eoi/{eoi}/comment', 'EoiController@comment')->name('eoi.comment');
    Route::get('eoi/{eoi}/commitment_letter', 'EoiController@commitment_letter')->name('eoi.commitment_letter');

    Route::resource('users', 'UserController')->only('index');

//    Route::get('eoi/{eoi}/services', [App\Http\Controllers\EoiController::class, 'services'])->name('eoi.services');
//    Route::post('eoi/{eoi}/services', [App\Http\Controllers\EoiController::class, 'update_services'])->name('eoi.services.update');

});

Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
