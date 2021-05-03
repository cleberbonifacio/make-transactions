<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WalletsController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\ArtigoController;

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

//Route Register User 1-Cliente and 2-Lojista
Route::post('register',[AuthController::class, 'register']);

//Route Login User
Route::post('login',[AuthController::class, 'login']);

//After Auth
Route::middleware('auth:api')->group(function(){
    ################## USER ##################
    //Route detail user
    Route::post('user/detail', [AuthController::class, 'user_detail']);

    ############### TRANSACTIONS ##############
    //Route transaction to other user
    Route::post('transactions', [TransactionsController::class, 'store']);

});
