<?php

use Illuminate\Http\Request;
use Illuminate\Routing\Router;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
* Snippet for a quick route reference
*/
Route::get('/', function (Router $router) {
    return collect($router->getRoutes()->getRoutesByMethod()["GET"])->map(function($value, $key) {
        return url($key);
    })->values();
});
//
//
//Route::apiResource('services', '\App\Http\Controllers\API\ServiceAPIController');
//
//Route::apiResource('connections', '\App\Http\Controllers\API\ConnectionAPIController');
//
//Route::apiResource('estimatedcosts', '\App\Http\Controllers\API\EstimatedcostAPIController');
//
//Route::apiResource('eois', '\App\Http\Controllers\API\EoiAPIController');
//
//Route::apiResource('operationcosts', '\App\Http\Controllers\API\OperationcostAPIController');
//
//Route::apiResource('bcps', '\App\Http\Controllers\API\BcpAPIController');
//
//Route::apiResource('bcpteams', '\App\Http\Controllers\API\BcpteamAPIController');
//
//Route::apiResource('staff', '\App\Http\Controllers\API\StaffAPIController');
//
//Route::apiResource('essentialfunctions', '\App\Http\Controllers\API\EssentialfunctionAPIController');
//
//Route::apiResource('essentialOperations', '\App\Http\Controllers\API\EssentialOperationAPIController');
//
//Route::apiResource('wsps', '\App\Http\Controllers\API\WspAPIController');
//
//Route::apiResource('revenues', '\App\Http\Controllers\API\RevenueAPIController');
//
//Route::apiResource('postalcodes', '\App\Http\Controllers\API\PostalcodeAPIController');
