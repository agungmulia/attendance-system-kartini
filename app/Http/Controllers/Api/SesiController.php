<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sesi;
use Validator;

class SesiController extends Controller
{
    public function destroy($id_sesi)
    {
        $Sesi = Sesi::where('sesis.id',$id_sesi )->first();
            
        if(is_null($Sesi)){
            return response([
                'message' => 'Sesi Tidak Ditemukan',
                'data' => null
            ],404);
        }


        if($Sesi->delete()){
            return response([
                'message' => 'Delete Sesi Success',
                'data' =>$Sesi
            ],200);
        }
       
        return response([
            'message' => 'Delete Sesi Failed',
            'data' => null,
        ],400);  
    }

    public function update(Request $request,$id)
    {
        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'nama_sesi' => 'required',
            'jam_mulai_sesi' => 'required',
            'jam_selesai_sesi' => 'required',
        ]);
        
        if($validate->fails())
            return response(['message' => $validate->errors()],400);
        
        
        $Sesi = Sesi::select('sesis.*')->where('sesis.id',$id)->first();
        $Sesi->nama_sesi = $updateData['nama_sesi'];
        $Sesi->jam_mulai_sesi = $updateData['jam_mulai_sesi'];
        $Sesi->jam_selesai_sesi = $updateData['jam_selesai_sesi'];
        if($Sesi->save()){
            return response([
                'message' => 'Tambah sesi berhasil!',
                'data' =>$Sesi
            ],200);      
        }
    }


    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'nama_sesi' => 'required',
            'jam_mulai_sesi' => 'required',
            'jam_selesai_sesi' => 'required',
        ]);
        
        if($validate->fails())
            return response(['message' => $validate->errors()],400);
        
        
        $Sesi = new Sesi();
        $Sesi->nama_sesi = $storeData['nama_sesi'];
        $Sesi->jam_mulai_sesi = $storeData['jam_mulai_sesi'];
        $Sesi->jam_selesai_sesi = $storeData['jam_selesai_sesi'];
        if($Sesi->save()){
            return response([
                'message' => 'Tambah sesi berhasil!',
                'data' =>$Sesi
            ],200);      
        }
    }

    public function index()
    {
        $Sesi = Sesi::all();

        if(count($Sesi)>0){
            return response([
                'message' => 'Retrieve All Success',
                'data' =>$Sesi
            ],200);
        }
        return response([
            'message' => 'Empty',
            'data' => null
        ],400);
    }

    public function show($id){
        $Sesi = Sesi::select('sesis.*')
                    ->where('sesis.id',$id )
                    ->first();

        if(!is_null($Sesi)){
            return response([
                'message' => 'Mengambil Data Sesi Berhasil',
                'data' =>$Sesi
            ],200);
        }
        return response([
            'message' => 'Sesi Tidak Ditemukan',
            'data' => null
        ],404);
    }
}