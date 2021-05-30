<?php

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

Route::get('/',"WelcomeController@index")->name('welcome');
Route::get('/category/{eventType?}/{eventId}',"WelcomeController@categories")->name('welcome.categories');
Route::get('/nominee/{eventType?}/{eventId}',"WelcomeController@nominees")->name('welcome.nominees');

Route::get('/nominee/{eventType?}/{nomineeId?}/details',"WelcomeController@nomineesDetails")->name('welcome.nominees.datails');



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/api/ussd', 'UssdController@ussdNalodWebhook')->name('nalo.hook');
Route::post('/api/ussd/variable/create', 'UssdTemplateController@create')->name('template.create');
// Dashboard
Route::group(['prefix'=>'dashboard','middleware'=>['auth']],function () {
    
    Route::get('/','DashboardController@index')->name('dashboard.index');

    // Events
    Route::get('event','EventsController@index')->name('event.index');
    Route::get('event/create','EventsController@create')->name('event.create');
    Route::post('event/create','EventsController@store')->name('event.store');

    // Category
    Route::get('category/{eventId}','CategoryController@index')->name('category.index');
    Route::get('category/{catId}/create','CategoryController@create')->name('category.create');
    Route::post('category/store/{eventId}','CategoryController@store')->name('category.store');


    // Nominees
    Route::get('nominee/create','NomineeController@create')->name('nominee.create');
    Route::get('nominee/{eventId}','NomineeController@index')->name('nominee.index');
    Route::post('nominee/store/{eventId}/{catId?}','NomineeController@store')->name('nominee.store');
    


     // Donation
     Route::get('donate/{eventId}','NomineeController@index')->name('donate.index');
     Route::get('donate/create','EventsController@create')->name('donate.create');



});


    
// paystack payment 
Route::group(['prefix'=>'payment'],function()
{
    Route::post('charge/{nomineeId}', 'PaymentController@charge')->name('payment.charge');
    // otp form
    Route::get('verify/{referenceId}', 'PaymentController@verify')->name('payment.otp');
    // submit otp
    Route::post('/request_otp/{reference}', 'PaymentController@send_otp')->name('payment.sendopt');
    // This shows a status of a completed otp page
    Route::get('verify/complete/{referenceId}', 'PaymentController@complete')->name('payment.complete');

});