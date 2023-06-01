<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GuruController;
use App\Http\Controllers\Api\JadwalController;
use App\Http\Controllers\Api\SiswaController;
use App\Http\Controllers\Api\AbsensiController;
use App\Http\Controllers\Api\PresensiController;
use App\Http\Controllers\Api\SesiController;
use App\Http\Controllers\PDFController;
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

Route::group(['middleware' => ['auth:api','guru']], function (){
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class,'logout']);
    Route::post('/gantiPassword', [AuthController::class,'changePassword']);

    //guru
    Route::get('guru', [GuruController::class,'index']);
    Route::get('guruProfile',[GuruController::class,'show']);
    Route::put('updateProfile',[GuruController::class,'updateProfile']);
    Route::get('kelasAnda',[GuruController::class,'kelasAnda']);
    Route::get('/cariPresensiKelas/{id}', [GuruController::class,'cariPresensiKelas']);

    //sesi
    Route::get('sesi', [SesiController::class,'index']);

    //jadwal
    Route::get('jadwal', [JadwalController::class,'index']);
    Route::get('jadwalGuru', [JadwalController::class,'jadwalGuru']);

    //siswa
    Route::get('showSiswaByKelas/{id}',[SiswaController::class,'showSiswaByKelas']);
    Route::get('siswa/{id}',[SiswaController::class,'show']);

    Route::post('/absen', [AbsensiController::class,'absen']);
    Route::post('/presensi', [PresensiController::class,'presensi']);

    Route::get('create-pdf-file', [PDFController::class, 'index']);

    Route::get('/keteranganabsensibyid/{id}', [AbsensiController::class,'keteranganAbsensiById']);
    Route::get('/keteranganpresensibyid/{id}/{tahun}', [PresensiController::class,'keteranganPresensiById']);

    Route::get('/tahunPresensi/{id}', [PresensiController::class,'tahunPresensi']);
});

Route::group(['middleware' => ['auth:api','siswa']], function (){
   Route::get('/userSiswa', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class,'logout']);

    Route::get('/dataAbsen', [SiswaController::class,'dataAbsen']);
    Route::get('/dataIzin', [SiswaController::class,'dataIzin']);
    Route::get('/profilsiswa', [SiswaController::class,'profilsiswa']);

    Route::post('/gantiPasswordSiswa', [AuthController::class,'changePasswordSiswa']);
    Route::put('updateProfileSiswa',[SiswaController::class,'updateProfileSiswa']);
    Route::get('presensiSiswa/{id}',[SiswaController::class,'presensiSiswa']);
    Route::get('/tahunPresensi', [SiswaController::class,'tahunPresensi']);
});


Route::post('/login', [AuthController::class,'login']);
Route::post('/loginsiswa', [AuthController::class,'loginSiswa']);