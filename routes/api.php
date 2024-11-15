<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\DetailAnggaranController;
use App\Http\Controllers\API\DetailKegitanController;
use App\Http\Controllers\API\DownloadLaporanController;
use App\Http\Controllers\API\ImportExcelController;
use App\Http\Controllers\API\KegiantanController;
use App\Http\Controllers\API\LaporanController;
use App\Http\Controllers\API\master\BidangController;
use App\Http\Controllers\API\master\KegiatanController as MasterKegiatanController;
use App\Http\Controllers\API\master\NomenKlaturController;
use App\Http\Controllers\API\master\OrganisasiController;
use App\Http\Controllers\API\master\PengawasController;
use App\Http\Controllers\API\master\ProgramController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\RealisasiController;
use App\Http\Controllers\API\master\SubKegiatanController;
use App\Http\Controllers\API\master\SumberDanaController;
use App\Http\Controllers\API\master\UnitController;
use App\Http\Controllers\API\master\UrusanController;
// use App\Http\Controllers\API\master\kegiatanController as MasterKegiatanController;
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
    Route::get('logout', [AuthController::class, 'logout']);
});
Route::get('get-permission', [AuthController::class, 'getAllPermissions']);

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
    Route::put('/verifikasi-admin/{detail_kegitan_id}', [KegiantanController::class, 'updateVerifikasiAdmin']);
    Route::put('/verifikasi-pengawas/{detail_kegitan_id}', [KegiantanController::class, 'updateVerifikasiPengawas']);
});

Route::group(['middleware' => 'api', 'prefix' => 'detail-kegiatan'], function () {
    Route::get('/kegitan-and-sub-kegiatan', [DetailKegitanController::class, 'getKegiatanAndSubKegiatan']);
    Route::get('/sub-kegiatan', [DetailKegitanController::class, 'getSubKegiatan']);
    Route::get('/program', [DetailKegitanController::class, 'getProgram']);
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

    //penaggung jawab
    Route::get('/penanggung-jawab', [DetailAnggaranController::class, 'getPenanggungJawab']);
    Route::put('/penanggung-jawab', [DetailAnggaranController::class, 'updatePenanggungJawab']);

    //get Dokumentasi
    Route::get('/dokumentasi', [DetailAnggaranController::class, 'getDokumentasi']);
    Route::post('/dokumentasi', [DetailAnggaranController::class, 'storeDokumentasi']);
    Route::post('/dokumentasi/{dokumen_id}', [DetailAnggaranController::class, 'updateDokumentasi']);
    Route::delete('/dokumentasi/{dokumen_id}', [DetailAnggaranController::class, 'deteletDokumentasi']);

    //get titik lokasi
    Route::get('/titik-lokasi', [DetailAnggaranController::class, 'getTitikLokasi']);
    Route::post('/titik-lokasi', [DetailAnggaranController::class, 'updateLokasi']);
});

// helper
Route::group(['middleware' => 'api'], function () {
    Route::get('/list-penanggung-jawab', [DetailAnggaranController::class, 'getListPenanggungJawab']);
    Route::get('/bidang-program', [MasterKegiatanController::class, 'getBidangAndProgram']);
    Route::get('/list-kegiatan ', [SubKegiatanController::class, 'getkegiatan']);
});

Route::group(['middleware' => 'api', 'prefix' => 'laporan'], function () {
    Route::get('/bidang', [LaporanController::class, 'getBidang']);
    Route::get('/', [LaporanController::class, 'index']);
});

// profile
Route::group(['middleware' => 'api', 'prefix' => 'profile'], function () {
    Route::get('/', [ProfileController::class, 'index']);
    Route::put('/', [ProfileController::class, 'update']);
    Route::put('/password', [ProfileController::class, 'updatePassword']);
    Route::post('/photo', [ProfileController::class, 'updateImage']);
});

// realisasi
Route::group(['middleware' => 'api', 'prefix' => 'realisasi'], function () {
    Route::get('/keuangan', [RealisasiController::class, 'RealisasiKeuangan']);
    Route::get('/fisik', [RealisasiController::class, 'RealisasiFisik']);
});

// download laporan
Route::group(['middleware' => 'api', 'prefix' => 'download'], function () {
    Route::get('/laporan', [DownloadLaporanController::class, 'downloadLaporan']);
});

// import
Route::group(['middleware' => 'api', 'prefix' => 'import'], function () {
    Route::post('/kegiatan', [ImportExcelController::class, 'importKegiatan']);
});


Route::group(['middleware' => 'api', 'prefix' => 'master'], function () {


    Route::group(['prefix' => 'bidang'], function () {
        Route::get('/', [BidangController::class, 'index']);
        Route::post('/', [BidangController::class, 'store']);
        Route::get('/{id}', [BidangController::class, 'show']);
        Route::put('/{id}', [BidangController::class, 'update']);
        Route::delete('/{id}', [BidangController::class, 'destroy']);
    });

    Route::group(['prefix' => 'pengawas'], function () {
        Route::get('/', [PengawasController::class, 'index']);
        Route::post('/', [PengawasController::class, 'store']);
        Route::get('/{id}', [PengawasController::class, 'show']);
        Route::put('/{id}', [PengawasController::class, 'update']);
        Route::delete('/{id}', [PengawasController::class, 'destroy']);
    });
    Route::group(['prefix' => 'kegiatan'], function () {
        Route::get('/', [MasterKegiatanController::class, 'index']);
        Route::post('/', [MasterKegiatanController::class, 'store']);
        Route::get('/{id}', [MasterKegiatanController::class, 'show']);
        Route::put('/{id}', [MasterKegiatanController::class, 'update']);
        Route::delete('/{id}', [MasterKegiatanController::class, 'destroy']);
    });

    Route::group(['prefix' => 'sub-kegiatan'], function () {
        Route::get('/', [SubKegiatanController::class, 'index']);
        Route::post('/', [SubKegiatanController::class, 'store']);
        Route::get('/{id}', [SubKegiatanController::class, 'show']);
        Route::put('/{id}', [SubKegiatanController::class, 'update']);
        Route::delete('/{id}', [SubKegiatanController::class, 'destroy']);
    });

    Route::group(['prefix' => 'program'], function () {
        Route::get('/', [ProgramController::class, 'index']);
        Route::post('/', [ProgramController::class, 'store']);
        Route::get('/{id}', [ProgramController::class, 'show']);
        Route::put('/{id}', [ProgramController::class, 'update']);
        Route::delete('/{id}', [ProgramController::class, 'destroy']);
    });

    Route::group(['prefix' => 'nomenklatur'], function () {
        Route::get('/', [NomenKlaturController::class, 'index']);
        Route::post('/', [NomenKlaturController::class, 'store']);
    });

    Route::group(['prefix' => 'sumber-dana'], function () {
        Route::get('/', [SumberDanaController::class, 'index']);
        Route::post('/', [SumberDanaController::class, 'store']);
        Route::get('/{id}', [SumberDanaController::class, 'show']);
        Route::put('/{id}', [SumberDanaController::class, 'update']);
        Route::delete('/{id}', [SumberDanaController::class, 'destroy']);
    });

    Route::group(['prefix' => 'urusan'], function () {
        Route::get('/', [UrusanController::class, 'index']);
        Route::post('/', [UrusanController::class, 'store']);
        Route::get('/{id}', [UrusanController::class, 'show']);
        Route::put('/{id}', [UrusanController::class, 'update']);
        Route::delete('/{id}', [UrusanController::class, 'destroy']);
    });

    Route::group(['prefix' => 'organisasi'], function () {
        Route::get('/', [OrganisasiController::class, 'index']);
        Route::post('/', [OrganisasiController::class, 'store']);
        Route::get('/{id}', [OrganisasiController::class, 'show']);
        Route::put('/{id}', [OrganisasiController::class, 'update']);
        Route::delete('/{id}', [OrganisasiController::class, 'destroy']);
    });
    Route::group(['prefix' => 'unit'], function () {
        Route::get('/', [UnitController::class, 'index']);
        Route::post('/', [UnitController::class, 'store']);
        Route::get('/{id}', [UnitController::class, 'show']);
        Route::put('/{id}', [UnitController::class, 'update']);
        Route::delete('/{id}', [UnitController::class, 'destroy']);
    });
});
