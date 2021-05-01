<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::apiResource('user', 'UserController');
// Route::apiResource('user_category', 'UserCategoryController')->only(['index']);
// Route::apiResource('wallet', 'WalletController')->only(['show', 'update']);
// Route::apiResource('transaction', 'TransactionController')->only(['index', 'store', 'show']);
