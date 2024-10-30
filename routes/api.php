<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\DetailAnggaranController;
use App\Http\Controllers\API\DetailKegitanController;
use App\Http\Controllers\API\KegiantanController;
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
    Route::get('/tabel-data', [DashboardController::class, 'getTabelData']);
});

Route::group(['middleware' => 'api', 'prefix' => 'kegiatan'], function () {
    Route::get('/', [KegiantanController::class, 'index']);
});

Route::group(['middleware' => 'api', 'prefix' => 'detail-kegiatan'], function () {
    Route::get('/kegitan-and-sub-kegiatan', [DetailKegitanController::class, 'getKegiatanAndSubKegiatan']);
    Route::get('/bidang-and-sumber-dana', [DetailKegitanController::class, 'getBidangAndSumberDana']);
    Route::post('/', [DetailKegitanController::class, 'store']);
    Route::get('/{detail_kegitan_id}', [DetailKegitanController::class, 'show']);
    Route::put('/{detail_kegitan_id}', [DetailKegitanController::class, 'update']);
    Route::delete('/{detail_kegitan_id}', [DetailKegitanController::class, 'destroy']);
});

Route::group(['middleware' => 'api', 'prefix' => 'detail-anggaran/{detail_kegitan_id}'], function () {
    //detail
    Route::get('/', [DetailAnggaranController::class, 'detail']);
    // kurfa fisik
    Route::get('/kurfa-fisik', [DetailAnggaranController::class, 'kurfaFisik']);
    Route::put('/kurfa-fisik/progres', [DetailAnggaranController::class, 'updateProgresFisik']);
    Route::put('/kurfa-fisik/rencana', [DetailAnggaranController::class, 'updateRencanaFisik']);
    // kurfa keuangan
    Route::get('/kurfa-keuangan', [DetailAnggaranController::class, 'kurfaKeuangan']);
    Route::put('/kurfa-keuangan', [DetailAnggaranController::class, 'updateProgresKeuangan']);
});
