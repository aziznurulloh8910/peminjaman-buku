<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;

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

Route::prefix('v1')->group(function () {
    Route::apiResource('role', RoleController::class)->middleware(['auth:api', 'isAdmin']);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('book', BookController::class);
    Route::apiResource('borrow', BorrowController::class);

    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('register', [AuthController::class, 'register']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
    Route::get('me', [AuthController::class, 'getUser'])->middleware(['auth:api']);
    Route::post('profile', [ProfileController::class, 'store'])->middleware(['auth:api']);
    Route::post('get-profile', [ProfileController::class, 'index'])->middleware('auth:api');
});
