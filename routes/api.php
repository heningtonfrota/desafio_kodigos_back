<?php

use App\Http\Controllers\{
    UserController,
    ProductController,
    SupplierController
};
use Illuminate\Support\Facades\Route;

Route::get('/version', fn() => response()->json(['version' => '1.0.0']));

Route::post('/tokens/create', [UserController::class, 'getToken']);

Route::apiResources([
    'users' => UserController::class,
    'products' => ProductController::class,
    'suppliers' => SupplierController::class,
]);
