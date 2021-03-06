<?php

use App\Http\Controllers\HomeController;
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

//Welcome routes
Route::get('/', function () {
    return view('welcome');
})->name('welcome');
Route::get('/contact', function(){
    return view('welcome');
})->name('contact');
Route::get('/docs', function(){
    return view('pages.docs');
})->name('docs');

Auth::routes();

//user routes
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/rotationlist', 'HomeController@rotationList')->name('home.rotations');
Route::get('/history', 'HomeController@transHistory')->name('transactions.history');
Route::get('/profile', 'HomeController@profileSettings')->name('user.profile');
Route::post('/user/updateProfile', 'HomeController@updateProfile');

Route::get('/payment/response', 'TransactionsController@processSTKPushRequestCallback');
Route::resource('/loans', 'LoansController', ['except' => ['create', 'show']]);
Route::resource('/transactions', 'TransactionsController', ['except' => ['show', 'create', 'destroy']]);


//Admin routes
Route::namespace('Admin')->prefix('admin')->name('admin.')->middleware('can:access-admin')->group(function(){
    Route::get('/dash', 'AdminController@index')->name('dash');
    Route::resource('/users', 'UsersController', ['except' => ['show', 'create', 'store']]);
    Route::get('/loans/all', 'FinancesController@allLoans')->name('loans.all');
    Route::get('/loans/requests', 'FinancesController@loanRequests')->name('loans.requests');
    Route::get('/accounts/all', 'FinancesController@accounts')->name('accounts.all');
    Route::get('/contributions/new', 'FinancesController@newContributions')->name('contributions.all');
    Route::get('/sms/new', 'CommunicationsController@newSms')->name('sms.new');
    Route::post('/sms/send', 'CommunicationsController@sendSingle')->name('sms.send');
    Route::get('/notices/new', 'CommunicationsController@newNotice')->name('notices.new');
    Route::post('/notices/post', 'CommunicationsController@postNotice')->name('notices.post');
    Route::post('/accounts/transfer', 'FinancesController@accountTransfer')->name('accounts.transfer');
});