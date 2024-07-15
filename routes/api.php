<?php

use App\Http\Controllers\{
    UserController,
    ProductController,
    ProductSupplierController,
    SupplierController
};
use Illuminate\Support\Facades\Route;

Route::get('version', fn() => response()->json(['version' => '1.0.0']));

Route::post('tokens/create', [UserController::class, 'getToken']);

Route::apiResources([
    'users' => UserController::class,
    'products' => ProductController::class,
    'suppliers' => SupplierController::class,
]);

Route::get('values-table', [ProductSupplierController::class, 'valuesTable']);
Route::put('update-value-supplier', [ProductSupplierController::class, 'updateValueSupplier']);
Route::put('update-is-winner-supplier', [ProductSupplierController::class, 'updateIsWinnerSupplier']);
Route::get('selected-suppliers', [ProductSupplierController::class, 'selectedSuppliers']);
