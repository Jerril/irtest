<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomersController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Fetch all customers
Route::get('/customers', [CustomersController::class, 'index']);

// Create new customer
Route::post('/customers', [CustomersController::class, 'store']);

// Fetch customer details
Route::get('/customers/{id}', [CustomersController::class, 'show']);

// Charge a customer card
Route::get('customers/debit/{id}', [CustomersController::class, 'debit']);