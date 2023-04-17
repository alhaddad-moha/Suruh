<?php

use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\SupplierController;
use App\Http\Controllers\API\UnitController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'v1',
    'namespace' => 'App\Http\Controllers\API'], function () {

    Route::group(['prefix' => 'auth'], function () {
        Route::controller(AuthController::class)->group(function () {
            Route::post('login', 'login');
            Route::post('register', 'register');
            Route::post('logout', 'logout');
            Route::post('refresh', 'refresh');
            Route::get('info', 'userDetails');
        });
    });

    Route::put('/category/edit/{id}', [CategoryController::class, 'update']);
    Route::apiResource('category', CategoryController::class);

    Route::put('/unit/edit/{id}', [UnitController::class, 'update']);
    Route::apiResource('unit', UnitController::class);

    Route::put('/supplier/edit/{id}', [SupplierController::class, 'update']);
    Route::apiResource('supplier', SupplierController::class);

    Route::put('/product/edit/{id}', [ProductController::class, 'update']);
    Route::apiResource('product', ProductController::class);

    Route::put('/customer/edit/{id}', [CustomerController::class, 'update']);
    Route::apiResource('customer', CustomerController::class);

    Route::put('/cart/edit/{id}', [CartController::class, 'update']);
    Route::apiResource('cart', CartController::class);

    Route::put('/order/edit/{id}', [OrderController::class, 'update']);
    Route::apiResource('order', OrderController::class);

});


