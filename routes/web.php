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
Route::get('/contact', function(){
    return view('welcome');
})->name('contact');

Auth::routes();
//

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/rotationlist', 'HomeController@rotationList')->name('home.rotations');




Route::get('payment/response', 'TransactionsController@processSTKPushRequestCallback');
//Route::get('payment/status', 'TransactionsController@getSTKPushStatus');

Route::resource('/loans', 'LoansController', ['except' => ['create', 'show']]);
Route::resource('/transactions', 'TransactionsController', ['except' => ['show', 'create', 'destroy']]);
Route::post('/accounts/transfer', 'Admin\FinancesController@accountTransfer')->name('accounts.transfer')->middleware('can:manage-finances');

//Admin
Route::namespace('Admin')->prefix('admin')->name('admin.')->middleware('can:access-admin')->group(function(){
    Route::get('/dash', function(){
        return view('admin.dash');
    })->name('dash');
    Route::resource('/users', 'UsersController', ['except' => ['show', 'create', 'store']]);
    Route::get('/loans/all', 'FinancesController@allLoans')->name('loans.all');
    Route::get('/loans/requests', 'FinancesController@loanRequests')->name('loans.requests');
    Route::get('/accounts/all', 'FinancesController@accounts')->name('accounts.all');
    Route::get('/contributions/new', 'FinancesController@newContributions')->name('contributions.all');
    Route::get('/sms/new', 'CommunicationsController@newSms')->name('sms.new');
    Route::get('/notices/new', 'CommunicationsController@newNotice')->name('notices.new');
});