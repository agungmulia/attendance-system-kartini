<?php

namespace App\Http\Controllers;
use Validator;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use PDF;

class PDFController extends Controller
{
     public function index(){
        $user_email = Auth::user()->email;
        $Guru = Guru::where('email_guru',$user_email )->value('nip_guru');
        $Kelas = Kelas::where('nip_guru' , $Guru )->value('kode_kelas');
        $tingkat_kelas = Kelas::where('nip_guru' , $Guru )->value('tingkat_kelas');
        $jurusan_kelas = Kelas::where('nip_guru' , $Guru )->value('jurusan_kelas');
        $nomor_kelas = Kelas::where('nip_guru' , $Guru )->value('nomor_kelas');

        $nama_kelas = $tingkat_kelas.' '.$jurusan_kelas.' '.$nomor_kelas;
        $Siswa = Siswa::join('absensis', 'siswas.nis_siswa', '=', 'absensis.nis_siswa')
            ->where('siswas.kode_kelas',$Kelas )
            ->select('siswas.nis_siswa','siswas.nama_siswa','absensis.hadir_absensi','absensis.izin_absensi','absensis.alpha_absensi',Siswa::raw("(absensis.hadir_absensi+(0.5*absensis.izin_absensi)/(absensis.hadir_absensi+absensis.izin_absensi+absensis.alpha_absensi))*100 as persentase"))
            ->get();

        $data = [
            'title' => 'Rekapitulasi Presensi Kelas '.$nama_kelas,
            'date' => date('m/d/Y'),
            'siswa' => $Siswa
        ]; 
        $pdf = PDF::loadView('testPDF',$data);
        return $pdf->download('Absensi.pdf');
    }
}