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
Route::get('test-confirm-email-template', function (){
    return new \App\Mail\ConfirmYourEmail();
});
Auth::routes();
Route::get('logout', function (){
   Auth::logout();
    return redirect('/');
});
Route::get('register/confirm', "ConfirmEmailController@confirmEmail")->name('confirm-register');
//Route::get('/{any?}', function () {
//    return view('layouts.main-app');
//})->where('any', '^(?!api\/)[\/\w\.\,-]*');
Route::get('/', function () {
    return view('layouts.main-app');
});

Route::prefix('admin')->group(function(){
    Route::resource('series', 'SeriesController');
});



//
//Route::get('/home', 'HomeController@index')->name('home');
