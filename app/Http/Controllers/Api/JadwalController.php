<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Siswa;
use App\Models\Guru;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JadwalController extends Controller
{
    public function index()
    {
        $user_email = Auth::user()->email;
        $nip_guru = Guru::where('email_guru', $user_email)->value('nip_guru');
        $Jadwal = Jadwal::join('gurus', 'jadwals.nip_guru', '=', 'gurus.nip_guru')
            ->join('siswas', 'jadwals.kode_kelas','=','siswas.kode_kelas')
            ->join('kelas','jadwals.kode_kelas','=','kelas.kode_kelas')
            ->where('gurus.nip_guru','=', $nip_guru)    
            ->select('jadwals.kode_jadwal','jadwals.kode_kelas','jadwals.sesi','jadwals.hari_jadwal','jadwals.mata_pelajaran_jadwal','kelas.nomor_kelas','kelas.tingkat_kelas','kelas.jurusan_kelas', 'gurus.nama_guru',DB::raw("count(siswas.nis_siswa) as total_murid"))
            ->groupBy('gurus.nama_guru','jadwals.kode_kelas','jadwals.sesi','jadwals.hari_jadwal','jadwals.mata_pelajaran_jadwal','kelas.nomor_kelas','kelas.tingkat_kelas','kelas.jurusan_kelas','jadwals.kode_jadwal')
            ->get();

        if(count($Jadwal)>0){
            return response([
                'message' => 'Retrieve All Success',
                'data' =>$Jadwal
            ],200);
        }
        return response([
            'message' => 'Empty',
            'data' => null
        ],400);
    }

    public function jadwalGuru(){
        $Jadwal = Jadwal::select('jadwals.sesi','jadwals.hari_jadwal','jadwals.mata_pelajaran_jadwal')
                    ->get();

        if(count($Jadwal)>0){
            return response([
                'message' => 'Retrieve All Success',
                'data' =>$Jadwal
            ],200);
        }
        return response([
            'message' => 'Empty',
            'data' => null
        ],400);
    }

   
}