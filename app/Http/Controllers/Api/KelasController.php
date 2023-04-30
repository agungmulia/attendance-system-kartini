<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Support\Facades\DB;

class KelasController extends Controller
{
    public function update(Request $request,$kode_kelas)
    {
        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'tingkat_kelas' => 'required',
            'jurusan_kelas' => 'required',
            'nomor_kelas' => 'required|numeric',
        ]);
        
        if($validate->fails())
            return response(['message' => $validate->errors()],400);
         
        $Kelas = Kelas::select('kelas.*')
            ->where('kelas.kode_kelas',$kode_kelas )
            ->first();
        $Kelas->tingkat_kelas = $updateData['tingkat_kelas'];
        $Kelas->jurusan_kelas = $updateData['jurusan_kelas'];
        $Kelas->nomor_kelas = $updateData['nomor_kelas'];
        if($Kelas->jurusan_kelas == 'Desain Komunikasi Visual'){
            $Kelas->kode_kelas = $updateData['tingkat_kelas'].'DKV'.$updateData['nomor_kelas'];
        }else if($Kelas->jurusan_kelas == 'Mesin'){
            $Kelas->kode_kelas = $updateData['tingkat_kelas'].'MSN'.$updateData['nomor_kelas'];
        }else if($Kelas->jurusan_kelas == 'Layanan Kesehatan'){
            $Kelas->kode_kelas = $updateData['tingkat_kelas'].'KSHTN'.$updateData['nomor_kelas'];
        }else if($Kelas->jurusan_kelas == 'Akuntansi & Keuangan Lembaga'){
            $Kelas->kode_kelas = $updateData['tingkat_kelas'].'AKN'.$updateData['nomor_kelas'];
        }else if($Kelas->jurusan_kelas == 'Otomotif'){
            $Kelas->kode_kelas = $updateData['tingkat_kelas'].'OTMF'.$updateData['nomor_kelas'];
        }else{
            return response([
            'message' => 'Kelas Tidak Valid',
        ],400);
        }
        if($Kelas->save()){
            return response([
                'message' => 'Ubah data kelas berhasil!',
                'data' =>$Kelas
            ],200);      
        }
    }

    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'tingkat_kelas' => 'required',
            'jurusan_kelas' => 'required',
            'nomor_kelas' => 'required|numeric',
        ]);
        
        if($validate->fails())
            return response(['message' => $validate->errors()],400);
        
        $Kelas = new Kelas();
        $Kelas->tingkat_kelas = $storeData['tingkat_kelas'];
        $Kelas->jurusan_kelas = $storeData['jurusan_kelas'];
        $Kelas->nomor_kelas = $storeData['nomor_kelas'];
        if($Kelas->jurusan_kelas == 'Desain Komunikasi Visual'){
            $Kelas->kode_kelas = $storeData['tingkat_kelas'].'DKV'.$storeData['nomor_kelas'];
        }else if($Kelas->jurusan_kelas == 'Mesin'){
            $Kelas->kode_kelas = $storeData['tingkat_kelas'].'MSN'.$storeData['nomor_kelas'];
        }else if($Kelas->jurusan_kelas == 'Layanan Kesehatan'){
            $Kelas->kode_kelas = $storeData['tingkat_kelas'].'KSHTN'.$storeData['nomor_kelas'];
        }else if($Kelas->jurusan_kelas == 'Akuntansi & Keuangan Lembaga'){
            $Kelas->kode_kelas = $storeData['tingkat_kelas'].'AKN'.$storeData['nomor_kelas'];
        }else if($Kelas->jurusan_kelas == 'Otomotif'){
            $Kelas->kode_kelas = $storeData['tingkat_kelas'].'OTMF'.$storeData['nomor_kelas'];
        }else{
            return response([
            'message' => 'Kelas Tidak Valid',
        ],400);
        }
        if($Kelas->save()){
            return response([
                'message' => 'Tambah kelas berhasil!',
                'data' =>$Kelas
            ],200);      
        }
    }

    public function destroy($kode_kelas)
    {
        Siswa::where('siswas.kode_kelas',$kode_kelas )
            ->update([
                'kode_kelas' => null,
            ]);
        $Kelas = Kelas::where('kelas.kode_kelas',$kode_kelas)->first();
            
        if(is_null($Kelas)){
            return response([
                'message' => 'Kelas Tidak Ditemukan',
                'data' => null
            ],404);
        }

        if($Kelas->delete()){
            return response([
                'message' => 'Hapus data kelas berhasil!',
                'data' =>$Kelas
            ],200);
        }
       
        return response([
            'message' => 'Hapus data kelas gagal!',
            'data' => null,
        ],400);  
    }


    public function index()
    {
        $Kelas = Kelas::leftJoin('gurus', 'kelas.nip_guru', '=', 'gurus.nip_guru')
            ->leftJoin('siswas', 'kelas.kode_kelas', '=', 'siswas.kode_kelas')
            ->select('gurus.nama_guru','gurus.nip_guru','kelas.kode_kelas','kelas.tingkat_kelas','kelas.jurusan_kelas','kelas.nomor_kelas',DB::raw("count(siswas.nis_siswa) as total_murid"))
            ->groupBy('gurus.nama_guru','gurus.nip_guru','kelas.kode_kelas','kelas.tingkat_kelas','kelas.jurusan_kelas','kelas.nomor_kelas')
            ->paginate(10);

        if(count($Kelas)>0){
            return $Kelas;
        }
        return response([
            'message' => 'Empty',
            'data' => null
        ],400);
    }

    public function searchFilterKelas(Request $request){
        $query = $request->get('query');

        $Kelas = Kelas::leftJoin('gurus', 'kelas.nip_guru', '=', 'gurus.nip_guru')
            ->leftJoin('siswas', 'kelas.kode_kelas', '=', 'siswas.kode_kelas')
            ->select('gurus.nama_guru','kelas.kode_kelas','kelas.tingkat_kelas','kelas.jurusan_kelas','kelas.nomor_kelas',DB::raw("count(siswas.nis_siswa) as total_murid"))
            ->groupBy('gurus.nama_guru','kelas.kode_kelas','kelas.tingkat_kelas','kelas.jurusan_kelas','kelas.nomor_kelas')
            ->where('tingkat_kelas', 'like', '%'.$query.'%')
            ->orWhere('jurusan_kelas', 'like', '%'.$query.'%')
            ->orWhere('nomor_kelas', 'like', '%'.$query.'%')
            ->paginate(10);

        if(count($Kelas)>0){
            return $Kelas;
        }
    }

    public function show($kode_kelas){
        $Kelas = Kelas::select('kelas.*')
                    ->where('kelas.kode_kelas',$kode_kelas )
                    ->first();

        if(!is_null($Kelas)){
            return response([
                'message' => 'Mengambil Data Kelas Berhasil',
                'data' =>$Kelas
            ],200);
        }
        return response([
            'message' => 'Kelas Tidak Ditemukan',
            'data' => null
        ],404);
    }

    public function kosongkanKelas($kode_kelas){
        Siswa::where('siswas.kode_kelas', $kode_kelas)->update(['siswas.kode_kelas' => null]);

        
        return response([
            'message' => 'Kelas Berhasil Dikosongkan!',
        ],404);
    }

    public function hapusWaliKelas($nip_guru){
        Kelas::where('kelas.nip_guru', $nip_guru)->update(['kelas.nip_guru' => null]);

        
        return response([
            'message' => 'Wali kelas berhasil Dihapus!',
        ],404);
    }
}