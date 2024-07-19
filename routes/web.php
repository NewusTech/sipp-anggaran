<?php

use App\Http\Controllers\Backend\AnggaranController;
use App\Http\Controllers\Backend\AssignPermissionController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\DetailKegiatanController;
use App\Http\Controllers\Backend\DokumentasiController;
use App\Http\Controllers\Backend\GrafikAnggaranController;
use App\Http\Controllers\Backend\PermissionController;
use App\Http\Controllers\Backend\PetunjukController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\ResetPasswordUserController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\BidangController;
use App\Http\Controllers\Backend\KegiatanController;
use App\Http\Controllers\Backend\ProgramController;
use App\Http\Controllers\Backend\PenyediaJasaController;
use App\Http\Controllers\Backend\InformasiUtamaController;
use App\Http\Controllers\Backend\NomenklaturController;
use App\Http\Controllers\Backend\InformasiTagihanController;
use App\Http\Controllers\Backend\ArsipController;
use App\Http\Controllers\Backend\PengambilanController;
use App\Http\Controllers\Backend\UrusanController;
use App\Http\Controllers\Backend\OrganisasiController;
use App\Http\Controllers\Backend\UnitController;
use App\Http\Controllers\Backend\SumberDanaController;
use App\Http\Controllers\Backend\DpaController;
use App\Http\Controllers\Backend\PenanggungJawabController;
use App\Http\Controllers\Backend\SubKegiatanController;
use App\Http\Controllers\Backend\PenggunaAnggaranController;
use App\Http\Controllers\Backend\TandaTanganController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
})->name('home.index');

Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);
Route::get('/chart-data', [DashboardController::class, 'chartData']);
Route::get('/maps-data', [DashboardController::class, 'mapsData']);

Route::group(['prefix' => 'backend', 'as' => 'backend.', 'middleware' => 'auth'], function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index')->middleware('permission:lihat dasbor');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile/update/{id}', [ProfileController::class, 'updateGeneralInformation'])->name('profile.update.information');
    Route::put('/profile/update/password/{id}', [ProfileController::class, 'updatePassword'])->name('profile.update.password');
    Route::post('/profile/update/image', [ProfileController::class, 'updateImage'])->name('profile.update.image');

    Route::group(['prefix' => 'roles'], function () {
        Route::get('/', [RoleController::class, 'index'])->name('roles.index');
        Route::get('/create', [RoleController::class, 'create'])->name('roles.create');
        Route::post('/', [RoleController::class, 'store'])->name('roles.store');
        Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
        Route::put('/{role}', [RoleController::class, 'update'])->name('roles.update');
        Route::delete('/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
    });

    Route::group(['prefix' => 'permissions'], function () {
        Route::get('/', [PermissionController::class, 'index'])->name('permissions.index');
        Route::get('/create', [PermissionController::class, 'create'])->name('permissions.create');
        Route::post('/', [PermissionController::class, 'store'])->name('permissions.store');
        Route::get('/{permission}/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
        Route::put('/{permission}', [PermissionController::class, 'update'])->name('permissions.update');
        Route::delete('/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');
    });

    Route::group(['prefix' => 'assignpermission'], function () {
        Route::get('/', [AssignPermissionController::class, 'index'])->name('assignpermission.index')->middleware('permission:lihat assign permission');
        Route::get('/{role}/edit', [AssignPermissionController::class, 'editRolePermission'])->name('assignpermission.edit')->middleware('permission:ubah assign permission');
        Route::post('/updaterolepermission', [AssignPermissionController::class, 'updateRolePermission'])->name('assignpermission.update')->middleware('permission:ubah assign permission');
    });

    Route::group(['prefix' => 'users'], function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index')->middleware('permission:lihat pengguna');
        Route::get('/create', [UserController::class, 'create'])->name('users.create')->middleware('permission:tambah pengguna');
        Route::post('/', [UserController::class, 'store'])->name('users.store')->middleware('permission:tambah pengguna');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('permission:ubah pengguna');
        Route::put('/{user}', [UserController::class, 'update'])->name('users.update')->middleware('permission:ubah pengguna');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy')->middleware('permission:hapus pengguna');
        Route::get('/{user}', [UserController::class, 'show'])->name('users.show')->middleware('permission:lihat pengguna');
        Route::patch('/{user}', [UserController::class, 'resetPassword'])->name('users.reset');
        Route::put('/users/{user}/resetpassword', [ResetPasswordUserController::class, 'resetPassword'])->name('users.reset.password')->middleware('permission:ubah pengguna');
    });

    Route::group(['prefix' => 'settings'], function () {
        Route::get('/index', [SettingController::class, 'index'])->name('setting.index')->middleware('permission:lihat pengaturan');
        Route::put('/updateinformation/{setting}/', [SettingController::class, 'updateInformation'])->name('setting.update.information')->middleware('permission:ubah pengaturan');
        Route::put('/updatelogo/{setting}/', [SettingController::class, 'updateLogo'])->name('setting.update.logo')->middleware('permission:ubah pengaturan');
        Route::put('/updatefrontimage/{setting}/', [SettingController::class, 'updateFrontImage'])->name('setting.update.front.image')->middleware('permission:ubah pengaturan');
    });

    Route::group(['prefix' => 'bidang'], function () {
        Route::get('/', [BidangController::class, 'index'])->name('bidang.index');
        Route::get('/create', [BidangController::class, 'create'])->name('bidang.create');
        Route::post('/', [BidangController::class, 'store'])->name('bidang.store');
        Route::get('/{id}/edit', [BidangController::class, 'edit'])->name('bidang.edit');
        Route::put('/{id}', [BidangController::class, 'update'])->name('bidang.update');
        Route::delete('/{id}', [BidangController::class, 'destroy'])->name('bidang.destroy');
        Route::get('/{id}', [BidangController::class, 'show'])->name('bidang.show');
    });

    Route::group(['prefix' => 'kegiatan'], function () {
        Route::get('/', [KegiatanController::class, 'index'])->name('kegiatan.index');
        Route::get('/pencarian', [KegiatanController::class, 'search'])->name('kegiatan.search');
        Route::get('/laporan', [KegiatanController::class, 'laporan'])->name('kegiatan.laporan');
        Route::get('/laporan/download', [KegiatanController::class, 'downloadLaporan'])->name('kegiatan.laporan.download');
        Route::get('/getKegiatan', [KegiatanController::class, 'getKegiatanByProgram'])->name('kegiatan.getKegiatanbyprogram');
        Route::get('/create', [KegiatanController::class, 'create'])->name('kegiatan.create');
        Route::post('/', [KegiatanController::class, 'store'])->name('kegiatan.store');
        Route::get('/{id}/edit', [KegiatanController::class, 'edit'])->name('kegiatan.edit');
        Route::put('/{id}', [KegiatanController::class, 'update'])->name('kegiatan.update');
        Route::delete('/{id}', [KegiatanController::class, 'destroy'])->name('kegiatan.destroy');
        Route::delete('/master/{id}', [KegiatanController::class, 'deleteMasterKegiatan'])->name('master.kegiatan.destroy');
        Route::get('/{id}', [KegiatanController::class, 'show'])->name('kegiatan.show');
        Route::post('/{id}', [KegiatanController::class, 'arship'])->name('kegiatan.arship');
        Route::post('pptk/{kegiatan_id}', [KegiatanController::class, 'updatePptk'])->name('kegiatan.pptk');
    });
    Route::group(['prefix' => 'program'], function () {
        Route::get('/', [ProgramController::class, 'index'])->name('program.index');
        Route::get('/create', [ProgramController::class, 'create'])->name('program.create');
        Route::post('/', [ProgramController::class, 'store'])->name('program.store');
        Route::get('/{id}/edit', [ProgramController::class, 'edit'])->name('program.edit');
        Route::put('/{id}', [ProgramController::class, 'update'])->name('program.update');
        Route::delete('/{id}', [ProgramController::class, 'destroy'])->name('program.destroy');
        Route::get('/{id}', [ProgramController::class, 'show'])->name('program.show');
    });
    Route::group(['prefix' => 'penyedia_jasa'], function () {
        Route::get('/', [PenyediaJasaController::class, 'index'])->name('penyedia_jasa.index');
        Route::get('/create', [PenyediaJasaController::class, 'create'])->name('penyedia_jasa.create');
        Route::post('/', [PenyediaJasaController::class, 'store'])->name('penyedia_jasa.store');
        Route::get('/{id}/edit', [PenyediaJasaController::class, 'edit'])->name('penyedia_jasa.edit');
        Route::put('/{id}', [PenyediaJasaController::class, 'update'])->name('penyedia_jasa.update');
        Route::delete('/{id}', [PenyediaJasaController::class, 'destroy'])->name('penyedia_jasa.destroy');
        Route::get('/{id}', [PenyediaJasaController::class, 'show'])->name('penyedia_jasa.show');
    });
    Route::group(['prefix' => 'informasi_utama'], function () {
        Route::get('/', [InformasiUtamaController::class, 'index'])->name('informasi_utama.index');
        Route::get('/create', [InformasiUtamaController::class, 'create'])->name('informasi_utama.create');
        Route::post('/', [InformasiUtamaController::class, 'store'])->name('informasi_utama.store');
        Route::get('/{id}/edit', [InformasiUtamaController::class, 'edit'])->name('informasi_utama.edit');
        Route::put('/{id}', [InformasiUtamaController::class, 'update'])->name('informasi_utama.update');
        Route::delete('/{id}', [InformasiUtamaController::class, 'destroy'])->name('informasi_utama.destroy');
        Route::get('/{id}', [InformasiUtamaController::class, 'show'])->name('informasi_utama.show');
    });
    Route::group(['prefix' => 'nomenklatur'], function () {
        Route::get('/', [NomenklaturController::class, 'index'])->name('nomenklatur.index');
        Route::get('/create', [NomenklaturController::class, 'create'])->name('nomenklatur.create');
        Route::post('/', [NomenklaturController::class, 'store'])->name('nomenklatur.store');
        Route::get('/{id}/edit', [NomenklaturController::class, 'edit'])->name('nomenklatur.edit');
        Route::put('/{id}', [NomenklaturController::class, 'update'])->name('nomenklatur.update');
        Route::delete('/{id}', [NomenklaturController::class, 'destroy'])->name('nomenklatur.destroy');
        Route::get('/{id}', [NomenklaturController::class, 'show'])->name('nomenklatur.show');
    });
    Route::group(['prefix' => 'informasi_tagihan'], function () {
        Route::get('/', [InformasiTagihanController::class, 'index'])->name('informasi_tagihan.index');
        Route::get('/create', [InformasiTagihanController::class, 'create'])->name('informasi_tagihan.create');
        Route::post('/', [InformasiTagihanController::class, 'store'])->name('informasi_tagihan.store');
        Route::get('/{id}/edit', [InformasiTagihanController::class, 'edit'])->name('informasi_tagihan.edit');
        Route::put('/{id}', [InformasiTagihanController::class, 'update'])->name('informasi_tagihan.update');
        Route::delete('/{id}', [InformasiTagihanController::class, 'destroy'])->name('informasi_tagihan.destroy');
        Route::get('/{id}', [InformasiTagihanController::class, 'show'])->name('informasi_tagihan.show');
    });
    Route::group(['prefix' => 'arsip'], function () {
        Route::get('/', [ArsipController::class, 'arsip'])->name('arsip.index');
    });
    Route::group(['prefix' => 'penanggung-jawab'], function () {
        Route::get('/', [PenanggungJawabController::class, 'index'])->name('penanggung_jawab.index');
        Route::post('/', [PenanggungJawabController::class, 'store'])->name('penanggung_jawab.store');
        Route::put('/{id}', [PenanggungJawabController::class, 'update'])->name('penanggung_jawab.update');
        Route::delete('/{id}', [PenanggungJawabController::class, 'destroy'])->name('penanggung_jawab.delete');
    });
    Route::group(['prefix' => 'petunjuk', 'as' => 'petunjuk.'], function () {
        Route::get('/', [PetunjukController::class, 'index'])->name('index');
        Route::post('/', [PetunjukController::class, 'store'])->name('store');
        Route::put('/{petunjuk}', [PetunjukController::class, 'update'])->name('update');
        Route::delete('/{petunjuk}', [PetunjukController::class, 'destroy'])->name('destroy');
    });
    Route::group(['prefix' => 'detail-kegiatan', 'as' => 'detail_kegiatan.'], function () {
        Route::post('/', [DetailKegiatanController::class, 'store'])->name('store');
        Route::post('/progress', [DetailKegiatanController::class, 'updateProgress'])->name('update.progress');
        Route::put('/{detail_kegiatan}', [DetailKegiatanController::class, 'update'])->name('update');
        Route::put('/verifikasi/{detail_kegiatan}', [DetailKegiatanController::class, 'updateVerifikasi'])->name('verifikasi');
        Route::put('detail/{detail_kegiatan}', [DetailKegiatanController::class, 'updateAnggaran'])->name('update.detail');
        Route::put('update/{detail_kegiatan}', [DetailKegiatanController::class, 'updateDetail'])->name('update.detail_kegiatan');
        Route::put('update-map/{detail_kegiatan}', [DetailKegiatanController::class, 'updateMapPoint'])->name('update.map_point');
        Route::delete('/{detail_kegiatan}', [DetailKegiatanController::class, 'destroy'])->name('destroy');
        Route::put('update-pengawas/{detail_kegiatan_id}', [DetailKegiatanController::class, 'updatePengawas'])->name('update.pengawas');
    });
    Route::group(['prefix' => 'detail-anggaran', 'as' => 'detail_anggaran.'], function () {
        Route::get('detail/{detail_kegiatan_id}', [AnggaranController::class, 'show'])->name('index');
        Route::get('detail/{detail_kegiatan_id}', [AnggaranController::class, 'show'])->name('index');
        Route::get('edit/{detail_kegiatan_id}', [AnggaranController::class, 'edit'])->name('edit');
        Route::put('update-kurva/{detail_kegiatan_id}', [AnggaranController::class, 'updateKurva'])->name('update_kurva');
        Route::post('tambah-progres/{detail_kegiatan_id}', [AnggaranController::class, 'addProgres'])->name('tambah_progres');
        Route::put('update-progres/{id}', [AnggaranController::class, 'updateProgres'])->name('update_progres');
        Route::delete('delete-progres/{id}', [AnggaranController::class, 'deleteProgres'])->name('delete_progres');
        Route::post('/', [AnggaranController::class, 'store'])->name('store');
        Route::put('/{anggaran}', [AnggaranController::class, 'update'])->name('update');
        Route::delete('/{anggaran}', [AnggaranController::class, 'destroy'])->name('destroy');
        Route::post('/dokumentasi', [DokumentasiController::class, 'store'])->name('dokumentasi.store');
        Route::put('/dokumentasi/{dokumentasi}', [DokumentasiController::class, 'update'])->name('dokumentasi.update');
        Route::delete('/dokumentasi/{dokumentasi}', [DokumentasiController::class, 'destroy'])->name('dokumentasi.destroy');
    });
    Route::group(['prefix' => 'data-anggaran', 'as' => 'data_anggaran.'], function () {
        Route::get('/{type}', [GrafikAnggaranController::class, 'index'])->name('index');
        Route::get('/progress/{type}', [GrafikAnggaranController::class, 'downloadProgress'])->name('progress');
        Route::get('/grafik/anggaran', [GrafikAnggaranController::class, 'downloadKeuangan'])->name('anggaran');
    });
    Route::group(['prefix' => 'pengambilan', 'as' => 'pengambilan.'], function () {
        Route::post('/', [PengambilanController::class, 'store'])->name('store');
        Route::post('/storeDpa', [PengambilanController::class, 'storeDpa'])->name('store.dpa');
        Route::get('/getPengambilan', [PengambilanController::class, 'getPengambilan'])->name('get');
        Route::get('/getPengambilanByDpa', [PengambilanController::class, 'getPengambilanByDpa'])->name('get.dpa');
        Route::delete('/{detail_kegiatan}', [PengambilanController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'urusan'], function () {
        Route::get('/', [UrusanController::class, 'index'])->name('urusan.index');
        Route::get('/create', [UrusanController::class, 'create'])->name('urusan.create');
        Route::post('/', [UrusanController::class, 'store'])->name('urusan.store');
        Route::get('/{id}/edit', [UrusanController::class, 'edit'])->name('urusan.edit');
        Route::put('/{id}', [UrusanController::class, 'update'])->name('urusan.update');
        Route::delete('/{id}', [UrusanController::class, 'destroy'])->name('urusan.destroy');
        Route::get('/{id}', [UrusanController::class, 'show'])->name('urusan.show');
    });

    Route::group(['prefix' => 'organisasi'], function () {
        Route::get('/', [OrganisasiController::class, 'index'])->name('organisasi.index');
        Route::get('/create', [OrganisasiController::class, 'create'])->name('organisasi.create');
        Route::post('/', [OrganisasiController::class, 'store'])->name('organisasi.store');
        Route::get('/{id}/edit', [OrganisasiController::class, 'edit'])->name('organisasi.edit');
        Route::put('/{id}', [OrganisasiController::class, 'update'])->name('organisasi.update');
        Route::delete('/{id}', [OrganisasiController::class, 'destroy'])->name('organisasi.destroy');
        Route::get('/{id}', [OrganisasiController::class, 'show'])->name('organisasi.show');
    });

    Route::group(['prefix' => 'unit'], function () {
        Route::get('/', [UnitController::class, 'index'])->name('unit.index');
        Route::get('/create', [UnitController::class, 'create'])->name('unit.create');
        Route::post('/', [UnitController::class, 'store'])->name('unit.store');
        Route::get('/{id}/edit', [UnitController::class, 'edit'])->name('unit.edit');
        Route::put('/{id}', [UnitController::class, 'update'])->name('unit.update');
        Route::delete('/{id}', [UnitController::class, 'destroy'])->name('unit.destroy');
        Route::get('/{id}', [UnitController::class, 'show'])->name('unit.show');
    });

    Route::group(['prefix' => 'sumber-dana', 'as' => 'sumber_dana.'], function () {
        Route::get('/', [SumberDanaController::class, 'index'])->name('index');
        Route::get('/create', [SumberDanaController::class, 'create'])->name('create');
        Route::post('/', [SumberDanaController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [SumberDanaController::class, 'edit'])->name('edit');
        Route::put('/{id}', [SumberDanaController::class, 'update'])->name('update');
        Route::delete('/{id}', [SumberDanaController::class, 'destroy'])->name('destroy');
        Route::get('/{id}', [SumberDanaController::class, 'show'])->name('show');
    });

    Route::group(['prefix' => 'dpa', 'as' => 'dpa.'], function () {
        Route::get('/', [DpaController::class, 'index'])->name('index');
        Route::get('/create', [DpaController::class, 'create'])->name('create');
        Route::post('/', [DpaController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [DpaController::class, 'edit'])->name('edit');
        Route::put('/{id}', [DpaController::class, 'update'])->name('update');
        Route::delete('/{id}', [DpaController::class, 'destroy'])->name('destroy');
        Route::get('/{id}', [DpaController::class, 'show'])->name('show');
        Route::get('/{id}/result', [DpaController::class, 'result'])->name('result');
    });

    Route::group(['prefix' => 'rencana', 'as' => 'rencana.'], function () {
        Route::get('/', [DpaController::class, 'getByProgram'])->name('program');
        Route::get('/{program_id}', [DpaController::class, 'getByKegiatan'])->name('kegiatan');
        Route::get('/{program_id}/detail/{kegiatan_id}', [DpaController::class, 'getByDetailKegiatan'])->name('detail');
        Route::get('/pengambilan/{detail_kegiatan_id}', [DpaController::class, 'getByPengambilan'])->name('pengambilan');
    });

    Route::group(['prefix' => 'sub-kegiatan', 'as' => 'sub_kegiatan.'], function () {
        Route::get('/', [SubKegiatanController::class, 'index'])->name('index');
        Route::post('/', [SubKegiatanController::class, 'store'])->name('store');
        Route::put('/{id}', [SubKegiatanController::class, 'update'])->name('update');
        Route::delete('/{id}', [SubKegiatanController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'pengguna-anggaran', 'as' => 'pengguna_anggaran.'], function () {
        Route::post('/', [PenggunaAnggaranController::class, 'store'])->name('store');
        Route::put('/{id}', [PenggunaAnggaranController::class, 'update'])->name('update');
        Route::delete('/{id}', [PenggunaAnggaranController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'tanda-tangan', 'as' => 'tanda_tangan.'], function () {
        Route::post('/', [TandaTanganController::class, 'store'])->name('store');
        Route::put('/{id}', [TandaTanganController::class, 'update'])->name('update');
        Route::delete('/{id}', [TandaTanganController::class, 'destroy'])->name('destroy');
    });
    Route::get('/download/fisik', [DashboardController::class, 'downloadPaketFisik'])->name('download.fisik');
    Route::get('/download/nonfisik', [DashboardController::class, 'downloadPaketNonFisik'])->name('download.nonfisik');
    Route::get('/download/kegiatan', [DashboardController::class, 'downloadPaketKegiatan'])->name('download.kegiatan');
    Route::get('/laporan', [KegiatanController::class, 'laporan'])->name('laporan');
});
