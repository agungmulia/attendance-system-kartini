<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Keterangan_Absensi;
use App\Models\Absensi;
use Illuminate\Support\Arr;

class AbsensiController extends Controller
{
    public function absen(Request $request)
    {
       $tableData = $request->input('tableData');
        foreach ($tableData as $item) {
            // process the data as necessary
            $absen = $item['absen'];
            $hari_absen = Carbon::parse($item['updated_at'])->format("Y-m-d");
            $hari_ini = Carbon::today()->format("Y-m-d");
            $nis_siswa = $item['nis_siswa'];
            $status_absensi = $item['status_absensi'];
            $keterangan_absensi = Keterangan_Absensi::whereDate('keterangan_absensis.updated_at',$hari_absen )->first();
            $Siswa = Absensi::where('absensis.nis_siswa',$nis_siswa )->first();
            $data_keterangan_absensi = Arr::only($item,[ 'keterangan_absensi','updated_at']);
            $data_keterangan_absensi['id_absensi'] = $Siswa['id'];
            $hadir_absensi = Absensi::where('absensis.nis_siswa',$nis_siswa )->value('hadir_absensi');
            $izin_absensi = Absensi::where('absensis.nis_siswa',$nis_siswa )->value('izin_absensi');
            $alpha_absensi = Absensi::where('absensis.nis_siswa',$nis_siswa )->value('alpha_absensi');
            
            if($absen == 'hadir'){
                if(Carbon::parse($hari_absen)->notEqualTo(Carbon::parse($hari_ini))){
                    Absensi::where('absensis.nis_siswa',$nis_siswa )
                        ->update([
                            'hadir_absensi' => $hadir_absensi+1, 
                            'status_absensi' => 'Hadir',
                            'updated_at' => Carbon::today()
                        ]);
                }else if(Carbon::parse($hari_absen)->equalTo(Carbon::parse($hari_ini))){
                    if($status_absensi == 'Izin'){
                        if($izin_absensi>0){
                            Absensi::where('absensis.nis_siswa',$nis_siswa )
                            ->update([
                                'izin_absensi' => $izin_absensi-1, 
                                'hadir_absensi'=> $hadir_absensi+1,
                                'status_absensi' => 'Hadir',
                            ]);
                            if($keterangan_absensi != null){
                                $keterangan_absensi->delete();
                            }
                        }else{
                            Absensi::where('absensis.nis_siswa',$nis_siswa )
                            ->update([
                                'hadir_absensi'=> $hadir_absensi+1,
                                'status_absensi' => 'Hadir',
                            ]);
                        }
                    }else if($status_absensi == 'Alpha'){
                        if($alpha_absensi>0){
                            Absensi::where('absensis.nis_siswa',$nis_siswa )
                            ->update([
                                'alpha_absensi' => $alpha_absensi-1, 
                                'hadir_absensi'=> $hadir_absensi+1,
                                'status_absensi' => 'Hadir',
                            ]);
                        }else{
                            Absensi::where('absensis.nis_siswa',$nis_siswa )
                            ->update([
                                'hadir_absensi'=> $hadir_absensi+1,
                                'status_absensi' => 'Hadir',
                            ]);
                        }
                    }else if($status_absensi == 'Hadir'){
                        Absensi::where('absensis.nis_siswa',$nis_siswa )
                        ->update([
                            'status_absensi' => 'Hadir',
                            'updated_at' => Carbon::today()
                        ]);
                    }else if($status_absensi == 'Belum Absen'){
                        Absensi::where('absensis.nis_siswa',$nis_siswa )
                        ->update([
                            'hadir_absensi'=> $hadir_absensi+1,
                            'status_absensi' => 'Hadir',
                            'updated_at' => Carbon::today()
                        ]);
                    }
                }
            }
            
            if($absen == 'izin'){
                if(Carbon::parse($hari_absen)->notEqualTo(Carbon::parse($hari_ini))){
                    Absensi::where('absensis.nis_siswa',$nis_siswa )
                        ->update([
                            'izin_absensi' => $izin_absensi+1, 
                            'status_absensi' => 'Izin',
                            'updated_at' => Carbon::today()
                        ]);

                    $keterangan = Keterangan_Absensi::insert($data_keterangan_absensi);
                }else if(Carbon::parse($hari_absen)->equalTo(Carbon::parse($hari_ini))){
                    if($status_absensi == 'Hadir'){
                        if($hadir_absensi>0){
                            Absensi::where('absensis.nis_siswa',$nis_siswa )
                            ->update([
                                'hadir_absensi' => $hadir_absensi-1, 
                                'izin_absensi' => $izin_absensi+1, 
                                'status_absensi' => 'Izin',
                            ]);

                            $keterangan = Keterangan_Absensi::insert($data_keterangan_absensi);
                        }else{
                            Absensi::where('absensis.nis_siswa',$nis_siswa )
                            ->update([
                                'izin_absensi'=> $izin_absensi+1,
                                'status_absensi' => 'Hadir',
                            ]);

                            $keterangan = Keterangan_Absensi::insert($data_keterangan_absensi);
                        }
                    }else if($status_absensi == 'Alpha'){
                        if($alpha_absensi>0){
                            Absensi::where('absensis.nis_siswa',$nis_siswa )
                            ->update([
                                'alpha_absensi' => $alpha_absensi-1, 
                                'izin_absensi' => $izin_absensi+1, 
                                'status_absensi' => 'Izin',
                            ]);
                            $keterangan = Keterangan_Absensi::insert($data_keterangan_absensi);
                        }else{
                            Absensi::where('absensis.nis_siswa',$nis_siswa )
                            ->update([
                                'izin_absensi'=> $izin_absensi+1,
                                'status_absensi' => 'Hadir',
                            ]);
                            $keterangan = Keterangan_Absensi::insert($data_keterangan_absensi);
                        }
                    }else if($status_absensi == 'Izin'){
                        Absensi::where('absensis.nis_siswa',$nis_siswa )
                        ->update([
                            'status_absensi' => 'Izin',
                            'updated_at' => Carbon::today()
                        ]);
                    }else if($status_absensi == 'Belum Absen'){
                        Absensi::where('absensis.nis_siswa',$nis_siswa )
                        ->update([
                            'izin_absensi'=> $izin_absensi+1,
                            'status_absensi' => 'Izin',
                            'updated_at' => Carbon::today()
                        ]);

                          $keterangan = Keterangan_Absensi::insert($data_keterangan_absensi);
                    }
                }
            }

            if($absen == 'alpha'){
                if(Carbon::parse($hari_absen)->notEqualTo(Carbon::parse($hari_ini))){
                    Absensi::where('absensis.nis_siswa',$nis_siswa )
                        ->update([
                            'alpha_absensi' => $alpha_absensi+1, 
                            'status_absensi' => 'Alpha',
                            'updated_at' => Carbon::today()
                        ]);
                }else if(Carbon::parse($hari_absen)->equalTo(Carbon::parse($hari_ini))){
                    if($status_absensi == 'Hadir'){
                        if($hadir_absensi>0){
                            Absensi::where('absensis.nis_siswa',$nis_siswa )
                            ->update([
                                'hadir_absensi' => $hadir_absensi-1, 
                                'alpha_absensi' => $alpha_absensi+1, 
                                'status_absensi' => 'Alpha',
                            ]);
                        }else{
                            Absensi::where('absensis.nis_siswa',$nis_siswa )
                            ->update([
                                'izin_absensi'=> $izin_absensi+1,
                                'status_absensi' => 'Hadir',
                            ]);
                        }
                    }else if($status_absensi == 'Alpha'){          
                            Absensi::where('absensis.nis_siswa',$nis_siswa )
                            ->update([                    
                                'status_absensi' => 'Alpha',
                            ]);
                     
                    }else if($status_absensi == 'Izin'){
                        if($izin_absensi>0){
                            Absensi::where('absensis.nis_siswa',$nis_siswa )
                            ->update([
                                'izin_absensi' => $izin_absensi-1, 
                                'alpha_absensi' => $alpha_absensi+1, 
                                'status_absensi' => 'Alpha',
                            ]);

                            if($keterangan_absensi != null){
                                $keterangan_absensi->delete();
                            }
                        }else{
                            Absensi::where('absensis.nis_siswa',$nis_siswa )
                            ->update([
                                'alpha_absensi'=> $alpha_absensi+1,
                                'status_absensi' => 'Alpha',
                            ]);

                            if($keterangan_absensi != null){
                                $keterangan_absensi->delete();
                            }
                        }
                    }else if($status_absensi == 'Belum Absen'){
                        Absensi::where('absensis.nis_siswa',$nis_siswa )
                        ->update([
                            'alpha_absensi'=> $alpha_absensi+1,
                            'status_absensi' => 'Alpha',
                        ]);
                    }
                }
            }    
        }
    }

    public function keteranganAbsensiById(Request $request,$nis_siswa){
        $keterangan_absensi = Keterangan_Absensi::Join('absensis', 'keterangan_absensis.id_absensi','=','absensis.id')
            ->select('keterangan_absensis.*')
            ->where('absensis.nis_siswa',$nis_siswa)
            ->get();

        if(count($keterangan_absensi)>0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $keterangan_absensi
            ],200);
        }
        return response([
            'message' => 'Empty',
            'data' => null
        ],400);
    }
}