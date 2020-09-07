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
/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

//user
Route::prefix('/user')->group( function(){
    Route::post('oauth', 'api\v1\AuthenticationController@authenticate');
    Route::get('all', 'api\v1\UserController@index')->middleware('auth:api');
    Route::post('new', 'api\v1\UserController@create');
    Route::post('forgot', 'Auth\ForgotPasswordController');
    Route::post('update', 'api\v1\UserController@update');
    
});

Route::prefix('/process')->group( function(){
    Route::post('loans/new', 'api\v1\ApiController@newLoan')->middleware('auth:api');
    Route::post('transactions/new', 'api\v1\ApiController@newTransaction')->middleware('auth:api');
    
});





