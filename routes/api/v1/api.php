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


//user
Route::prefix('/user')->group( function(){
    Route::post('oauth', 'Api\v1\AuthenticationController@authenticate');
    Route::get('all', 'Api\v1\UserController@index')->middleware('auth:api');
    Route::get('history/{id}', 'api\v1\UserController@transHistory')->middleware('auth:api');
    Route::post('new', 'Api\v1\UserController@create');
    Route::post('forgot', 'Auth\ForgotPasswordController');
    Route::post('update', 'Api\v1\UserController@update')->middleware('auth:api');
    
});

Route::prefix('/process')->group( function(){
    Route::post('loans/new', 'api\v1\ApiController@newLoan')->middleware('auth:api');
    Route::post('transactions/new', 'api\v1\ApiController@newTransaction')->middleware('auth:api');
    
});





