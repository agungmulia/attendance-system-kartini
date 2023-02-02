<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GuruController extends Controller
{
    public function index()
    {
        $Guru = Guru::all();

        if(count($Guru)>0){
            return response([
                'message' => 'Retrieve All Success',
                'data' =>$Guru
            ],200);
        }
        return response([
            'message' => 'Empty',
            'data' => null
        ],400);
    }

    public function updateProfile(Request $request)
    {
        $user_email = Auth::user()->email;
        $Guru = Guru::where('email_guru',$user_email )->value('nip_guru');
        $Guru = Guru::select('gurus.*')
            ->where('gurus.email_guru',$user_email )
            ->first();
        if(is_null($Guru)){
            return response([
                'message' => 'Guru Not Found',
                'data' => null
            ],404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData,[
            
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()],400);

        $Guru->alamat_guru = $updateData['alamat_guru'];
        $Guru->no_telp_guru = $updateData['no_telp_guru'];
        
        if($Guru->save()){
            return response([
                'message' => 'Update Guru Success',
                'data' => $Guru
            ],200);
        }

        return response([
            'message' => 'Update Guru failed',
            'data' => null,
        ],400);
    }

    public function show()
    {
        $user_email = Auth::user()->email;
        $Guru = Guru::select('gurus.*')
            ->where('gurus.email_guru',$user_email )
            ->get();
            
        
        if(!is_null($Guru)){
            return response([
                'message' => 'Mengambil Data Guru Berhasil',
                'data' =>$Guru
            ],200);
        }
        return response([
            'message' => 'Guru Tidak Ditemukan',
            'data' => null
        ],404);
    }

    public function kelasAnda(){
        $user_email = Auth::user()->email;
        $Guru = Guru::where('email_guru',$user_email )->value('nip_guru');
        $Kelas = Kelas::where('wali_kelas' , $Guru )->value('kode_kelas');
        $Siswa = Siswa::select('siswas.*')
            ->where('siswas.kode_kelas',$Kelas )
            ->select('siswas.nis_siswa','siswas.nama_siswa','siswas.hadir_siswa','siswas.izin_siswa','siswas.alpha_siswa')
            ->get();
        if(!is_null($Siswa)){
            return response([
                'message' => 'Mengambil Data Kelas Berhasil',
                'data' =>$Siswa
            ],200);
        }
        return response([
            'message' => 'Kelas Tidak Ditemukan',
            'data' => null
        ],404);
    }
}