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
Route::get('/', function (){
    return response()->json(['api_status' => 'oke']);
});

Route::prefix('payments')->group(function (){
    Route::get('/', 'PaymentController@index');
    Route::post('/', 'PaymentController@store');
    Route::delete('/{id}', 'PaymentController@destroy');
    Route::put('/{id}', 'PaymentController@update');
    Route::patch('/{id}/activate', 'PaymentController@activate');
    Route::patch('/{id}/deactivate', 'PaymentController@deactivate');
});
