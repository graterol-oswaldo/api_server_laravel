<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProductController;




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
Route::middleware('auth:api')->prefix('auth')->group(function () {

    Route::post('logout',   [AuthController::class, 'logout']);
    Route::get('products', [ProductController::class, 'index'])->name('products.index');

});


Route::middleware('guest:api')->group(function () {
    Route::post('login',    [AuthController::class, 'login']);
    Route::post('register', [RegisterController::class, 'index']);

});


Route::fallback(function(){
    abort(403, 'Unauthorized action.');
});
