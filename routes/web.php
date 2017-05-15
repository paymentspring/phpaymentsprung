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

Route::get('/charges/card', function () {
    return view('charges/card');
});

Route::post('charges/card', 'ChargesController@card');