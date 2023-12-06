<?php

use App\Http\Controllers\Api\V1\InvoiceController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix("v1")->group(function () {
    Route::get("users", [UserController::class, "index"])->name("users");
    Route::get("users/{user}", [UserController::class, "show"])->name("users.show");

    Route::apiResource('invoices', InvoiceController::class);
});
