<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
})->name('welcome');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



Route::get('/contact', function(){
    return view('welcome');
})->name('contact');
Route::get('payment/response', 'TransactionsController@processSTKPushRequestCallback');
//Route::get('payment/status', 'TransactionsController@getSTKPushStatus');

Route::resource('/loans', 'LoansController', ['except' => ['create', 'store', 'destroy']]);
Route::resource('/transactions', 'TransactionsController', ['except' => ['show', 'create', 'destroy']]);

//Admin
Route::namespace('Admin')->prefix('admin')->name('admin.')->middleware('can:access-admin')->group(function(){
    Route::get('/dash', function(){
        return view('admin.dash');
    });
    Route::resource('/users', 'UsersController', ['except' => ['show', 'create', 'store']]);
});