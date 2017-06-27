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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/customers', 'CustomersController@index');

Route::get('/customers/new', function () {
    return view('customers/new');
});

Route::post('/customers', 'CustomersController@create');

Route::get('customers/search', function() {
    return view('customers/search');
});

Route::post('customers/search', 'CustomersController@search');

// View forms for charges
Route::get('/charges/card', function () {
    return view('charges/card');
});

Route::get('charges/bank', function() {
    return view('charges/bank');
});

//Post a new charge
Route::post('charges/new', 'ChargesController@newCharge');

Route::get('plans/new', function() {
    return view('plans/new');
});

Route::post('plans/new', 'PlansController@new');

Route::get('subscriptions/new', function() {
    return view('subscriptions/new');
});

Route::post('subscriptions/new', 'SubscriptionsController@new');
