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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {

    Route::get('wsps/export', [App\Http\Controllers\WspController::class, 'import_view'])->name('wsps.export');
    Route::post('wsps/import', [App\Http\Controllers\WspController::class, 'import'])->name('wsps.import');

    Route::get('eoi', [App\Http\Controllers\EoiController::class, 'create']);
    Route::post('eoi', [App\Http\Controllers\EoiController::class, 'store'])->name('eoi.store');

    Route::get('eoi/attachments/{filename}', [App\Http\Controllers\EoiController::class, 'getAttachment'])->name('eoi.attachments.show');
    Route::delete('eoi/attachments/{attachment}', [App\Http\Controllers\EoiController::class, 'deleteAttachment'])->name('eoi.attachments.destroy');
    Route::get('eoi/{eoi}/attachments', [App\Http\Controllers\EoiController::class, 'attachments'])->name('eoi.attachments');
    Route::post('eoi/{eoi}/attachments', [App\Http\Controllers\EoiController::class, 'store_attachments'])->name('eoi.attachments.store');
    Route::get('eoi/{eoi}/preview', [App\Http\Controllers\EoiController::class, 'preview']);
    Route::get('eoi/{eoi}/commitment_letter', [App\Http\Controllers\EoiController::class, 'commitment_letter']);

//    Route::get('eoi/{eoi}/services', [App\Http\Controllers\EoiController::class, 'services'])->name('eoi.services');
//    Route::post('eoi/{eoi}/services', [App\Http\Controllers\EoiController::class, 'update_services'])->name('eoi.services.update');

});

Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
