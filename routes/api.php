<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockTransferController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\WarehouseController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    // Protected routes
    Route::apiResource('/products', ProductController::class);
    Route::apiResource('/warehouses', WarehouseController::class);
    Route::apiResource('/suppliers', SupplierController::class);
    Route::apiResource('/stock-transfers', StockTransferController::class);

    //dropdown-list
    Route::get('/product-list', [ProductController::class, 'list']);
    Route::get('/warehouse-list', [WarehouseController::class, 'list']);
    Route::get('/supplier-list', [SupplierController::class, 'list']);

    //warehouseStockHistory
    Route::get('/warehouse/stock-transfers', [StockTransferController::class, 'warehouseStockHistory']);
});
