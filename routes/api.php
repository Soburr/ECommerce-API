<?php

use App\Http\Controllers\LocationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Models\Location;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api')->name('refresh');
    Route::post('/me', [AuthController::class, 'me'])->middleware('auth:api')->name('me');
});


Route::controller(BrandController::class)->group(function() {
    Route::get('index', 'index');
    Route::get('show/{id}','show');
    Route::post('store', 'store');
    Route::put('update_brand/{id}', 'update_brand');
    Route::delete('delete_brand/{id}', 'delete_brand');
});


Route::controller(CategoryController::class)->group(function() {
    Route::get('index', 'index');
    Route::get('show/{id}','show');
    Route::post('store', 'store');
    Route::put('update_category/{id}', 'update_category');
    Route::delete('delete_category/{id}', 'delete_category');
});


Route::controller(LocationController::class)->group(function() {
    Route::post('store', 'store');
    Route::put('update_location/{id}', 'update_location');
    Route::delete('delete_location/{id}', 'delete_location');
});


Route::controller(ProductController::class)->group(function() {
    Route::get('index', 'index');
    Route::get('show/{id}','show');
    Route::post('store', 'store');
    Route::put('update_product/{id}', 'update_product');
    Route::delete('delete_product/{id}', 'delete_product');
});

Route::controller(OrderController::class)->group(function() {
    Route::get('index', 'index');
    Route::get('show/{id}','show');
    Route::post('store', 'store');
    Route::get('get_order_items/{id}', 'get_order_items');
    Route::get('get_user_orders/{id}', 'get_user_orders');
    Route::get('change_order_status/{id}', 'change_order_status');
});
