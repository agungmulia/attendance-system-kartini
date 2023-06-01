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
        $Siswa = Siswa::join('presensis', 'siswas.nis_siswa', '=', 'presensis.nis_siswa')
            ->where('siswas.kode_kelas',$Kelas )
            ->select('siswas.nis_siswa','siswas.nama_siswa','presensis.total_hadir_presensi','presensis.total_izin_presensi','presensis.total_alpha_presensi',Siswa::raw("(((presensis.total_hadir_presensi+(0.5*presensis.total_izin_presensi))/(presensis.total_hadir_presensi+presensis.total_izin_presensi+presensis.total_alpha_presensi))*100) as persentase"))
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