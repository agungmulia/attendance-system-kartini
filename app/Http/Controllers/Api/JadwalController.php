<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Sesi;
use App\Models\Kelas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Validator;

class JadwalController extends Controller
{
    public function destroy($kode_jadwal)
    {
        $Jadwal = Jadwal::where('jadwals.kode_jadwal',$kode_jadwal )->first();
            
        if(is_null($Jadwal)){
            return response([
                'message' => 'Jadwal Tidak Ditemukan',
                'data' => null
            ],404);
        }


        if($Jadwal->delete()){
            return response([
                'message' => 'Delete Jadwal Success',
                'data' =>$Jadwal
            ],200);
        }
       
        return response([
            'message' => 'Delete Jadwal Failed',
            'data' => null,
        ],400);  
    }

    public function update(Request $request,$kode_jadwal)
    {
        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'mata_pelajaran_jadwal' => 'required',
            'hari_jadwal' => 'required',
            'kode_kelas' => 'required',
            'sesi' => 'required',
            'nip_guru' => 'required',
        ]);
        
        if($validate->fails())
            return response(['message' => $validate->errors()],400);
        
        
        $Jadwal = Jadwal::select('jadwals.*')
            ->where('jadwals.kode_jadwal',$kode_jadwal )
            ->first();
        $Jadwal->mata_pelajaran_jadwal = $updateData['mata_pelajaran_jadwal'];
        $Jadwal->hari_jadwal = $updateData['hari_jadwal'];
        $Jadwal->kode_kelas = $updateData['kode_kelas'];
        $Jadwal->sesi = $updateData['sesi'];
        $Jadwal->nip_guru = $updateData['nip_guru'];
        if($Jadwal->save()){
            return response([
                'message' => 'Tambah Jadwal berhasil!',
                'data' =>$Jadwal
            ],200);      
        }
    }


    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'mata_pelajaran_jadwal' => 'required',
            'hari_jadwal' => 'required',
            'kode_kelas' => 'required',
            'sesi' => 'required',
            'nip_guru' => 'required',
        ]);
        
        if($validate->fails())
            return response(['message' => $validate->errors()],400);
        

	    $kode_jadwal = IdGenerator::generate(['table' => 'jadwals','field'=>'kode_jadwal', 'length' => 18, 'prefix' => 'JDW-'.$storeData['nip_guru']]);

        $Jadwal = new Jadwal();
        $Jadwal->kode_jadwal = $kode_jadwal;
        $Jadwal->mata_pelajaran_jadwal = $storeData['mata_pelajaran_jadwal'];
        $Jadwal->hari_jadwal = $storeData['hari_jadwal'];
        $Jadwal->kode_kelas = $storeData['kode_kelas'];
        $Jadwal->sesi = $storeData['sesi'];
        $Jadwal->nip_guru = $storeData['nip_guru'];
        if($Jadwal->save()){
            return response([
                'message' => 'Tambah Jadwal berhasil!',
                'data' =>$Jadwal
            ],200);      
        }
    }
    public function totalData(){
       $Siswa = Siswa::count();
       $Guru = Guru::count();
       $Kelas = Kelas::count();
       $Sesi = Sesi::count();
       $Jadwal = Jadwal::count();

       return response([
                'message' => 'Retrieve All Success',
                'data' =>['total_siswa'=>$Siswa,'total_guru'=>$Guru,'total_kelas'=>$Kelas,'total_sesi'=>$Sesi,'total_jadwal'=>$Jadwal]
            ],200);
    }
    public function dataJadwal()
    {
        $Guru = Guru::select('gurus.nama_guru')
            ->get();
        $Sesi = Sesi::select('sesis.nama_sesi','sesis.jam_mulai_sesi','sesis.jam_selesai_sesi')
            ->get();
        $Kelas = Kelas::select('kelas.tingkat_kelas','kelas.jurusan_kelas','kelas.nomor_kelas')
            ->get();

        if(count($Guru)>0){
            return response([
                'message' => 'Retrieve All Success',
                'data' =>['Guru'=>$Guru,'Sesi'=>$Sesi,'Kelas'=>$Kelas]
            ],200);
        }
        return response([
            'message' => 'Empty',
            'data' => null
        ],400);
    }
    public function index()
    {
        $user_email = Auth::user()->email;
        $nip_guru = Guru::where('email_guru', $user_email)->value('nip_guru');
        $Jadwal = Jadwal::leftJoin('siswas', 'jadwals.kode_kelas','=','siswas.kode_kelas')
            ->leftJoin('kelas','jadwals.kode_kelas','=','kelas.kode_kelas')
            ->leftJoin('gurus','jadwals.nip_guru','=','gurus.nip_guru')
            ->leftJoin('sesis','jadwals.sesi','=','sesis.id')
            ->where('jadwals.nip_guru','=', $nip_guru)    
            ->select('sesis.jam_mulai_sesi','sesis.jam_selesai_sesi','jadwals.kode_jadwal','jadwals.kode_kelas','sesis.nama_sesi','jadwals.hari_jadwal','jadwals.mata_pelajaran_jadwal','kelas.nomor_kelas','kelas.tingkat_kelas','kelas.jurusan_kelas', 'gurus.nama_guru',DB::raw("count(siswas.nis_siswa) as total_murid"))
            ->groupBy('sesis.jam_mulai_sesi','sesis.jam_selesai_sesi','gurus.nama_guru','jadwals.kode_kelas','sesis.nama_sesi','jadwals.hari_jadwal','jadwals.mata_pelajaran_jadwal','kelas.nomor_kelas','kelas.tingkat_kelas','kelas.jurusan_kelas','jadwals.kode_jadwal')
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

    public function indexJadwal()
    {
        $Jadwal = Jadwal::leftJoin('siswas', 'jadwals.kode_kelas','=','siswas.kode_kelas')
            ->leftJoin('kelas','jadwals.kode_kelas','=','kelas.kode_kelas')
            ->leftJoin('gurus','jadwals.nip_guru','=','gurus.nip_guru')
            ->leftJoin('sesis','jadwals.sesi','=','sesis.id')
            ->select('sesis.jam_mulai_sesi','sesis.jam_selesai_sesi','jadwals.kode_jadwal','jadwals.kode_kelas','jadwals.sesi','jadwals.hari_jadwal','jadwals.mata_pelajaran_jadwal','kelas.nomor_kelas','kelas.tingkat_kelas','kelas.jurusan_kelas', 'gurus.nama_guru',DB::raw("count(siswas.nis_siswa) as total_murid"))
            ->groupBy('sesis.jam_mulai_sesi','sesis.jam_selesai_sesi','gurus.nama_guru','jadwals.kode_kelas','jadwals.sesi','jadwals.hari_jadwal','jadwals.mata_pelajaran_jadwal','kelas.nomor_kelas','kelas.tingkat_kelas','kelas.jurusan_kelas','jadwals.kode_jadwal')
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
        $user_email = Auth::user()->email;
        $nip_guru = Guru::where('email_guru', $user_email)->value('nip_guru');
        $Jadwal = Jadwal::select('jadwals.sesi','jadwals.hari_jadwal','jadwals.mata_pelajaran_jadwal')
        ->where('jadwals.nip_guru','=', $nip_guru)   
                    ->get();

        if(count($Jadwal)>0){
            return response([
                'message' => 'Retrieve All Success',
                'data' =>$Jadwal
            ],200);
        }
        return response([
            'message' => 'Empty',
            'data' => 'Data Kosong'
        ],400);
    }

   public function show($kode_jadwal){
        $Jadwal = Jadwal::join('kelas', 'jadwals.kode_kelas', '=', 'kelas.kode_kelas')
                    ->join('gurus', 'jadwals.nip_guru', '=', 'gurus.nip_guru')
                    ->join('sesis', 'jadwals.sesi', '=', 'sesis.id')
                    ->select('jadwals.*','gurus.nama_guru','kelas.tingkat_kelas','kelas.jurusan_kelas','kelas.nomor_kelas','sesis.nama_sesi','sesis.jam_mulai_sesi','sesis.jam_selesai_sesi')
                    ->where('jadwals.kode_jadwal',$kode_jadwal )
                    ->first();

        if(!is_null($Jadwal)){
            return response([
                'message' => 'Mengambil Data Jadwal Berhasil',
                'data' =>$Jadwal
            ],200);
        }
        return response([
            'message' => 'Jadwal Tidak Ditemukan',
            'data' => null
        ],404);
    }
}