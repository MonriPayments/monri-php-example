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

Route::get('/', function () {
    return view('welcome');
});

Route::controller(\App\Http\Controllers\ExamplesController::class)->group(function () {
    Route::get('/confirm-payment', 'confirmPayment');
    Route::get('/create-and-confirm-payment', 'createAndConfirmPayment');
    Route::post('/confirm-payment-with-token', 'confirmPaymentWithToken');
    Route::get('/customer/{id}', 'customer');
});
