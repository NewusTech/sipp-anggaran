<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\DashboardController;
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


Route::group(['middleware' => 'api', 'prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
});

Route::group(['middleware' => 'api', 'prefix' => 'users'], function () {
    Route::get('/', [AuthController::class, 'getUserData']);
});


Route::group(['middleware' => 'api', 'prefix' => 'dashboard'], function () {
    Route::get('/total-pagu-realisasi', [DashboardController::class, 'getTotalPaguAndRelasi']);
    Route::get('/chart', [DashboardController::class, 'getChartRealisasi']);
    Route::get('/realisasi-data', [DashboardController::class, 'getRealisasiDataAndCont']);
});
