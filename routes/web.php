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
//Route::get('/{series_by_id}', function (\App\Model\Series $series){
//   dd($series);
//});
Route::get('test-collection', function (){
    dump(\Illuminate\Support\Facades\DB::table('series')->get());
    dump(\App\Model\Series::all());
});
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
Route::get('/','HomeController@index')->name('home');

Route::get('set-redis', function () {
//    \Illuminate\Support\Facades\Redis::set('friends', 'huy');
//    \Illuminate\Support\Facades\Redis::sadd('testSet', 'huy');
//    \Illuminate\Support\Facades\Redis::sadd('testSet', 'huy');
//    \Illuminate\Support\Facades\Redis::sadd('testSet', 'ha');
//    \Illuminate\Support\Facades\Redis::sadd('testSet', 'han');
    dd(\Illuminate\Support\Facades\Redis::smembers('testSet'));
});
Route::get('series/{series}', 'HomeController@showSeries')->name('series');
Route::get('watch-series/{series}', 'WatchSeriesController@index')->name('watch-series');
Route::get('series/{series}/lesson/{lesson}', 'WatchSeriesController@watchLesson')->middleware('check-lesson-access')->name('watch-series.lesson');
Route::post('series/complete-lesson/{lesson}', 'WatchSeriesController@completeLesson')->name('watch-series.complete-lesson');
//
//Route::get('/home', 'HomeController@index')->name('home');
Route::get('profile/{user}', 'ProfileController@getProfile')->name('profile');
Route::post('update-user/{email}', 'ProfileController@updateUser')->name('update-user');

Route::get('subscribe', 'SubscriptionController@showSubscription')->name('show-subscribe')->middleware('check-subscribe');
Route::post('post-subscribe', 'SubscriptionController@processSubscription')->name('post-subscribe')->middleware('check-subscribe');

// welcome page only for subscribed users
Route::middleware('subscribed')->group(function(){
    Route::get('welcome-subscribe', 'SubscriptionController@showWelcome')->name('subscribed');
    Route::post('update-plan', 'SubscriptionController@updatePlan')->name('update-plan');
    Route::post('update-payment-method', 'SubscriptionController@updatePayment')->name('update-payment');
});
