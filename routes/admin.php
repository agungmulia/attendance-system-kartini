<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GuruController;
use App\Http\Controllers\Api\SiswaController;
use App\Http\Controllers\Api\KelasController;
use App\Http\Controllers\Api\SesiController;
use App\Http\Controllers\Api\AbsensiController;
use App\Http\Controllers\Api\PresensiController;
use App\Http\Controllers\Api\JadwalController;
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

Route::group(['middleware' => ['auth:api','admin']], function (){
    Route::post('/logout', [AuthController::class,'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::put('/guru/{id}', [GuruController::class,'update']);
    Route::post('/guru', [GuruController::class,'store']);
    Route::get('/guru', [GuruController::class,'index']);
    Route::get('/guru/{id}', [GuruController::class,'cariGuru']);
    Route::delete('/guru/{id}', [GuruController::class,'destroy']);
    Route::get('/searchFilterGuru', [GuruController::class,'searchFilterGuru']);

    Route::put('/siswa/{id}', [SiswaController::class,'update']);
    Route::post('/siswa', [SiswaController::class,'store']);
    Route::get('/siswa', [SiswaController::class,'index']);
    Route::get('/siswa/{id}', [SiswaController::class,'show']);
    Route::delete('/siswa/{id}', [SiswaController::class,'destroy']);
    Route::get('/searchFilterSiswa', [SiswaController::class,'searchFilterSiswa']);

    Route::put('/kosongkanKelas/{id}', [KelasController::class,'kosongkanKelas']);
    Route::put('/hapusWaliKelas/{id}', [KelasController::class,'hapusWaliKelas']);
    Route::get('/kelas', [KelasController::class,'index']);
    Route::post('/kelas', [KelasController::class,'store']);
    Route::delete('/kelas/{id}', [KelasController::class,'destroy']);
    Route::put('/kelas/{id}', [KelasController::class,'update']);
    Route::get('/kelas/{id}', [KelasController::class,'show']);
    Route::get('/searchFilterKelas', [KelasController::class,'searchFilterKelas']);

    Route::post('sesi', [SesiController::class,'store']);
    Route::get('sesi', [SesiController::class,'index']);
    Route::delete('/sesi/{id}', [SesiController::class,'destroy']);
    Route::put('/sesi/{id}', [SesiController::class,'update']);
    Route::get('/sesi/{id}', [SesiController::class,'show']);

    Route::get('jadwal', [JadwalController::class,'indexJadwal']);
    Route::post('jadwal', [JadwalController::class,'store']);
    Route::get('/jadwal/{id}', [JadwalController::class,'show']);
    Route::put('/jadwal/{id}', [JadwalController::class,'update']);
    Route::delete('/jadwal/{id}', [JadwalController::class,'destroy']);
    Route::get('dataJadwal', [JadwalController::class,'dataJadwal']);
    Route::get('/searchFilterJadwal', [JadwalController::class,'searchFilterJadwal']);

    Route::post('/detailPresensi', [PresensiController::class,'detailPresensi']);

    Route::get('totalData', [JadwalController::class,'totalData']);

    
});

Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'loginAdmin']);