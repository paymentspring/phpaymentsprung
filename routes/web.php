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

Route::get('/charges/card', function () {
    return view('charges/card');
});

Route::post('charges/card', 'ChargesController@chargeCard');

Route::get('charges/bank', function() {
    return view('charges/bank');
});
Route::post('charges/bank', 'ChargesController@chargeBank');
