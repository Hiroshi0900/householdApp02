<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => ['api']], function () {
    Route::resource(
        'gss',
        'Api\GoogleSpreadSheetController'
    );
    // Route::resource('gss/add', 'Api\GoogleSpreadSheetController@add');
    // Route::get('gss/add', 'GoogleSpreadSheetController@add');
});

// Route::get('test', 'GoogleSpreadSheetController@add');
