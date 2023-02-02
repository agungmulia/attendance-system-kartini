<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;

class SiswaController extends Controller
{
     public function showSiswaByKelas($kode_kelas)
    {
       $Siswa = Siswa::select('siswas.*')
            ->where('siswas.kode_kelas',$kode_kelas )
            ->select('siswas.nama_siswa')
            ->get();

        if(count($Siswa)>0){
            return response([
                'message' => 'Retrieve All Success',
                'data' =>$Siswa
            ],200);
        }
        return response([
            'message' => 'Empty',
            'data' => null
        ],400);
    }
    
    public function index()
    {
        $Siswa = Siswa::all();

        if(count($Siswa)>0){
            return response([
                'message' => 'Retrieve All Success',
                'data' =>$Siswa
            ],200);
        }
        return response([
            'message' => 'Empty',
            'data' => null
        ],400);
    }

    public function show($nis_siswa){
        $Siswa = Siswa::select('siswas.*')
                    ->where('siswas.nis_siswa',$nis_siswa )
                    ->get();
        if(!is_null($Siswa)){
            return response([
                'message' => 'Mengambil Data Siswa Berhasil',
                'data' =>$Siswa
            ],200);
        }
        return response([
            'message' => 'Siswa Tidak Ditemukan',
            'data' => null
        ],404);
    }
}