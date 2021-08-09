<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TreasureHuntController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;

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
Route::group([
    'middleware' => 'api',
    'prefix' => 'v1'

], function ($router) {
    Route::group([
        'prefix' => 'auth'    
    ], function ($router) {
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::get('/user-profile', [AuthController::class, 'userProfile']);    
    });

    Route::group([
        'prefix' => 'product'    
    ], function ($router) {
        Route::post('/create', [ProductController::class, 'createProduct']); 
        Route::post('/get', [ProductController::class, 'getProduct']); 
    });

    Route::group([
        'prefix' => 'cart'    
    ], function ($router) {
        Route::post('/add', [TransactionController::class, 'addToCart']); 
        Route::post('/get', [TransactionController::class, 'getCart']); 
    });

    Route::get('/treasure-hunt', [TreasureHuntController::class, 'treasureHunt']);
});
