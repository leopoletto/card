<?php

use App\Http\Controllers\CreateCardSwitcherTaskController;
use App\Http\Controllers\CreateCardController;
use App\Http\Controllers\ListLatestTaskByMerchantController;
use App\Http\Controllers\ListMerchantsController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\UpdateCardSwitcherTaskStatusController;
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

Route::post('/users', RegisterUserController::class);
Route::post('/login', LoginController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/cards', CreateCardController::class);
    Route::get('/merchants', ListMerchantsController::class);
    Route::post('/card-switcher-tasks', CreateCardSwitcherTaskController::class);
    Route::patch('/card-switcher-tasks/{cardSwitcherTask}/fail', [UpdateCardSwitcherTaskStatusController::class, 'fail']);
    Route::patch('/card-switcher-tasks/{cardSwitcherTask}/finalize', [UpdateCardSwitcherTaskStatusController::class, 'finalize']);
    Route::get('/latest-card-switcher-tasks', ListLatestTaskByMerchantController::class);
});
