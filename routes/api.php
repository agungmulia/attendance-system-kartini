<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GuruController;
use App\Http\Controllers\Api\JadwalController;
use App\Http\Controllers\Api\SiswaController;
use App\Http\Controllers\Api\AbsensiController;
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
    Route::post('/logout', [AuthController::class,'logout']);
    Route::post('/gantiPassword', [AuthController::class,'changePassword']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    //guru
    Route::get('guru', [GuruController::class,'index']);
    Route::get('guruProfile',[GuruController::class,'show']);
    Route::put('updateProfile',[GuruController::class,'updateProfile']);
    Route::get('kelasAnda',[GuruController::class,'kelasAnda']);

    //sesi
    Route::get('sesi', [SesiController::class,'index']);

    //jadwal
    Route::get('jadwal', [JadwalController::class,'index']);
    Route::get('jadwalGuru', [JadwalController::class,'jadwalGuru']);

    //siswa
    Route::get('showSiswaByKelas/{id}',[SiswaController::class,'showSiswaByKelas']);
    Route::get('siswa/{id}',[SiswaController::class,'show']);

    Route::post('/absen', [AbsensiController::class,'absen']);

    Route::get('create-pdf-file', [PDFController::class, 'index']);

    Route::get('/keteranganabsensibyid/{id}', [AbsensiController::class,'keteranganAbsensiById']);

});

Route::group(['middleware' => ['auth:api','siswa']], function (){
   
});


Route::post('/login', [AuthController::class,'login']);
Route::post('/loginsiswa', [AuthController::class,'loginSiswa']);