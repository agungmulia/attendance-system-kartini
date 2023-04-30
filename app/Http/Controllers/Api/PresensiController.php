<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Detail_Presensi;
use App\Models\Presensi;
use App\Models\Siswa;
use Illuminate\Support\Arr;
use Validator;
use Illuminate\Support\Facades\Http;

class PresensiController extends Controller
{
    public function detailPresensi(Request $request){
        $requestData = $request->all();
        $nama_siswa = $request->nama_siswa;
        $tanggal_mulai_presensi = $request->tanggal_mulai_presensi;
        $tanggal_selesai_presensi = $request->tanggal_selesai_presensi;
        $validate = Validator::make($requestData, [
            'nama_siswa' => 'required',
            'tanggal_mulai_presensi' => 'required',
            'tanggal_selesai_presensi' => 'required',
        ]);
        
        if($validate->fails())
            return response(['message' => $validate->errors()],400);

        $data = Detail_Presensi::join('siswas', 'detail_presensis.nis_siswa', '=', 'siswas.nis_siswa')
            ->whereBetween('detail_presensis.updated_at', [$tanggal_mulai_presensi, $tanggal_selesai_presensi])
            ->where('siswas.nama_siswa', $nama_siswa)
            ->select('detail_presensis.*','siswas.nama_siswa')
            ->get();
        $total_hadir = Detail_Presensi::join('siswas', 'detail_presensis.nis_siswa', '=', 'siswas.nis_siswa')
            ->whereBetween('detail_presensis.updated_at', [$tanggal_mulai_presensi, $tanggal_selesai_presensi])
            ->where('siswas.nama_siswa', $nama_siswa)
            ->where('detail_presensis.status_presensi','hadir')
            ->count();
        $total_izin = Detail_Presensi::join('siswas', 'detail_presensis.nis_siswa', '=', 'siswas.nis_siswa')
            ->whereBetween('detail_presensis.updated_at', [$tanggal_mulai_presensi, $tanggal_selesai_presensi])
            ->where('siswas.nama_siswa', $nama_siswa)
            ->where('detail_presensis.status_presensi','izin')
            ->count();
        $total_alpha = Detail_Presensi::join('siswas', 'detail_presensis.nis_siswa', '=', 'siswas.nis_siswa')
            ->whereBetween('detail_presensis.updated_at', [$tanggal_mulai_presensi, $tanggal_selesai_presensi])
            ->where('siswas.nama_siswa', $nama_siswa)
            ->where('detail_presensis.status_presensi','alpha')
            ->count();
        if(count($data)>0){
            return response([
                'message' => 'Mengambil Data Presensi Berhasil',
                'total_hadir' => $total_hadir,
                'total_izin' => $total_izin,
                'total_alpha' => $total_alpha,
                'data' =>$data,
            ],200);
        }
        return response([
            'message' => 'Data presensi tidak ditemukan!',
            'data' => null
        ],404);
    }
    public function presensi(Request $request)
    {
        
       $tableData = $request->input('tableData');
        foreach ($tableData as $item) {
            setlocale(LC_TIME, 'id');
            $absen = $item['absen'];
            $nis_siswa = $item['nis_siswa'];
            $status_presensi = $item['status_presensi'];
            $keterangan_presensi = $item['keterangan_presensi'];

            $hari_absen = Carbon::parse($item['updated_at'])->format("Y-m-d");
            $hari_ini = Carbon::today()->format("Y-m-d");

            $token = "ceG9ywMWBHbknwgGwxfU5tPaAxx4KDf1jGah57QX2N2hgg2weJ";
            $no_telp_orang_tua = Siswa::where('siswas.nis_siswa',$nis_siswa)->value('no_telp_orang_tua');
            $nama_siswa = Siswa::where('siswas.nis_siswa',$nis_siswa)->value('nama_siswa');

            $Siswa = Presensi::where('presensis.nis_siswa',$nis_siswa )->first();
            $data_detail_presensi = Arr::only($item,[ 'nis_siswa','keterangan_presensi']);
            $data_detail_presensi['updated_at'] = Carbon::today();
            $data_detail_presensi['status_presensi'] = $item['absen'];
            $data_detail_presensi['id_presensi'] = $Siswa['id'];
            
            $total_hadir_presensi = Presensi::where('presensis.nis_siswa',$nis_siswa )->value('total_hadir_presensi');
            $total_izin_presensi = Presensi::where('presensis.nis_siswa',$nis_siswa )->value('total_izin_presensi');
            $total_alpha_presensi = Presensi::where('presensis.nis_siswa',$nis_siswa )->value('total_alpha_presensi');
            
            if($absen == 'hadir'){
                if(Carbon::parse($hari_absen)->notEqualTo(Carbon::parse($hari_ini))){
                    Presensi::where('presensis.nis_siswa',$nis_siswa )
                        ->update([
                            'total_hadir_presensi' => $total_hadir_presensi+1, 
                            'status_presensi' => 'Hadir',
                            'updated_at' => Carbon::today()
                        ]);
                    $keterangan = Detail_Presensi::insert($data_detail_presensi);

                    if($no_telp_orang_tua != null){
                        $client = new \GuzzleHttp\Client([
                            'verify' => 'C:\xampp\php\extras\ssl\cacert.pem'
                        ]);

                        $response = $client->post('https://app.ruangwa.id/api/send_message', [
                            'form_params' => [
                                'token' => $token,
                                'number' => $no_telp_orang_tua,
                                'message' => "Bapak/Ibu Wali dari $nama_siswa,
Status presensi $nama_siswa pada waktu ".Carbon::now()->formatLocalized('%A, %d %B %Y pukul %H:%M')." adalah *$absen*

*Ini adalah pesan otomatis yang dibuat dari sistem presensi SMKS Kartini Batam*",
                            ],
                        ]);

                        echo $response->getBody();
                    }
                    
                }else if(Carbon::parse($hari_absen)->equalTo(Carbon::parse($hari_ini))){
                    if($status_presensi == 'Izin'){
                        if($total_izin_presensi>0){
                            Presensi::where('presensis.nis_siswa',$nis_siswa )
                            ->update([
                                'total_izin_presensi' => $total_izin_presensi-1, 
                                'total_hadir_presensi'=> $total_hadir_presensi+1,
                                'status_presensi' => 'Hadir',
                            ]);
                                Detail_Presensi::where('detail_presensis.id_presensi',$data_detail_presensi['id_presensi'] )
                                ->whereDate('detail_presensis.updated_at',now()->toDateString())
                                ->update([
                                    'status_presensi' => 'Hadir', 
                                    'keterangan_presensi'=> null,
                                    'updated_at' => Carbon::now()
                                ]);
                       
                        }else{
                            Presensi::where('presensis.nis_siswa',$nis_siswa )
                            ->update([
                                'total_hadir_presensi'=> $total_hadir_presensi+1,
                                'status_presensi' => 'Hadir',
                            ]);
                         
                                Detail_Presensi::where('detail_presensis.id_presensi',$data_detail_presensi['id_presensi'] )
                                ->whereDate('detail_presensis.updated_at',now()->toDateString())
                                ->update([
                                    'status_presensi' => 'Hadir', 
                                    'keterangan_presensi'=> null,
                                    'updated_at' => Carbon::now()

                                ]);
                        }

                        if($no_telp_orang_tua != null){
                            $client = new \GuzzleHttp\Client([
                                'verify' => 'C:\xampp\php\extras\ssl\cacert.pem'
                            ]);

                            $response = $client->post('https://app.ruangwa.id/api/send_message', [
                                'form_params' => [
                                    'token' => $token,
                                    'number' => $no_telp_orang_tua,
                                    'message' => "Bapak/Ibu Wali dari $nama_siswa,
Status presensi $nama_siswa pada waktu ".Carbon::now()->formatLocalized('%A, %d %B %Y pukul %H:%M')." sebelumnya *$status_presensi* diganti menjadi *$absen*

*Ini adalah pesan otomatis yang dibuat dari sistem presensi SMKS Kartini Batam*",
                                ],
                            ]);

                            echo $response->getBody();
                        }
                    }else if($status_presensi == 'Alpha'){
                        if($total_alpha_presensi>0){
                            Presensi::where('presensis.nis_siswa',$nis_siswa )
                            ->update([
                                'total_alpha_presensi' => $total_alpha_presensi-1, 
                                'total_hadir_presensi'=> $total_hadir_presensi+1,
                                'status_presensi' => 'Hadir',
                            ]);
                          
                                Detail_Presensi::where('detail_presensis.id_presensi',$data_detail_presensi['id_presensi'] )
                                ->whereDate('detail_presensis.updated_at',now()->toDateString())
                                ->update([
                                    'status_presensi' => 'Hadir', 
                                    'keterangan_presensi'=> null,
                                    'updated_at' => Carbon::now()

                                ]);
                          
                        }else{
                            Presensi::where('presensis.nis_siswa',$nis_siswa )
                            ->update([
                                'total_hadir_presensi'=> $total_hadir_presensi+1,
                                'status_presensi' => 'Hadir',
                            ]);
                         
                                Detail_Presensi::where('detail_presensis.id_presensi',$data_detail_presensi['id_presensi'] )
                                ->whereDate('detail_presensis.updated_at',now()->toDateString())
                                ->update([
                                    'status_presensi' => 'Hadir', 
                                    'keterangan_presensi'=> null,
                                    'updated_at' => Carbon::now()

                                ]);
                          
                        }
                        if($no_telp_orang_tua != null){
                            $client = new \GuzzleHttp\Client([
                                'verify' => 'C:\xampp\php\extras\ssl\cacert.pem'
                            ]);

                            $response = $client->post('https://app.ruangwa.id/api/send_message', [
                                'form_params' => [
                                    'token' => $token,
                                    'number' => $no_telp_orang_tua,
                                    'message' => "Bapak/Ibu Wali dari $nama_siswa,
Status presensi $nama_siswa pada waktu ".Carbon::now()->formatLocalized('%A, %d %B %Y pukul %H:%M')." sebelumnya *$status_presensi* diganti menjadi *$absen*

*Ini adalah pesan otomatis yang dibuat dari sistem presensi SMKS Kartini Batam*",
                                ],
                            ]);

                            echo $response->getBody();
                        }
                    }else if($status_presensi == 'Hadir'){
                        Presensi::where('presensis.nis_siswa',$nis_siswa )
                        ->update([
                            'status_presensi' => 'Hadir',
                            'updated_at' => Carbon::today()
                        ]);
                        Detail_Presensi::where('detail_presensis.id_presensi',$data_detail_presensi['id_presensi'] )
                                ->whereDate('detail_presensis.updated_at',now()->toDateString())
                                ->update([
                                    'status_presensi' => 'Hadir', 
                                    'keterangan_presensi'=> null,
                                    'updated_at' => Carbon::now()

                                ]);
                    }else if($status_presensi == 'Belum Absen'){
                        Presensi::where('presensis.nis_siswa',$nis_siswa )
                        ->update([
                            'total_hadir_presensi'=> $total_hadir_presensi+1,
                            'status_presensi' => 'Hadir',
                            'updated_at' => Carbon::now()
                        ]);
                        $keterangan = Detail_Presensi::insert($data_detail_presensi);
                        if($no_telp_orang_tua != null){
                        $client = new \GuzzleHttp\Client([
                            'verify' => 'C:\xampp\php\extras\ssl\cacert.pem'
                        ]);

                        $response = $client->post('https://app.ruangwa.id/api/send_message', [
                                'form_params' => [
                                    'token' => $token,
                                    'number' => $no_telp_orang_tua,
                                    'message' => "Bapak/Ibu Wali dari $nama_siswa,
Status presensi $nama_siswa pada waktu ".Carbon::now()->formatLocalized('%A, %d %B %Y pukul %H:%M')." adalah *$absen*

*Ini adalah pesan otomatis yang dibuat dari sistem presensi SMKS Kartini Batam*",
                                ],
                            ]);

                            echo $response->getBody();
                        }
                    }
                }
            }
            
            if($absen == 'izin'){
                if(Carbon::parse($hari_absen)->notEqualTo(Carbon::parse($hari_ini))){
                    Presensi::where('presensis.nis_siswa',$nis_siswa )
                        ->update([
                            'total_izin_presensi' => $total_izin_presensi+1, 
                            'status_presensi' => 'Izin',
                            'updated_at' => Carbon::today()
                        ]);
                    $keterangan = Detail_Presensi::insert($data_detail_presensi);
                    if($no_telp_orang_tua != null){
                        $client = new \GuzzleHttp\Client([
                            'verify' => 'C:\xampp\php\extras\ssl\cacert.pem'
                        ]);

                        $response = $client->post('https://app.ruangwa.id/api/send_message', [
                            'form_params' => [
                                'token' => $token,
                                'number' => $no_telp_orang_tua,
                                'message' => "Bapak/Ibu Wali dari $nama_siswa,
Status presensi $nama_siswa pada waktu ".Carbon::now()->formatLocalized('%A, %d %B %Y pukul %H:%M')." adalah *$absen* dengan keterangan $keterangan_presensi

*Ini adalah pesan otomatis yang dibuat dari sistem presensi SMKS Kartini Batam*",
                            ],
                        ]);

                        echo $response->getBody();
                    }
                }else if(Carbon::parse($hari_absen)->equalTo(Carbon::parse($hari_ini))){
                    if($status_presensi == 'Hadir'){
                        if($total_hadir_presensi>0){
                            Presensi::where('presensis.nis_siswa',$nis_siswa )
                            ->update([
                                'total_hadir_presensi' => $total_hadir_presensi-1, 
                                'total_izin_presensi' => $total_izin_presensi+1, 
                                'status_presensi' => 'Izin',
                            ]);

                           
                                Detail_Presensi::where('detail_presensis.id_presensi',$data_detail_presensi['id_presensi'] )
                                ->whereDate('detail_presensis.updated_at',now()->toDateString())
                                ->update([
                                    'status_presensi' => 'Izin', 
                                    'keterangan_presensi'=> $item['keterangan_presensi'],
                                    'updated_at' => Carbon::now()
                                ]);
                         
                        }else{
                            Presensi::where('presensis.nis_siswa',$nis_siswa )
                            ->update([
                                'total_izin_presensi'=> $total_izin_presensi+1,
                                'status_presensi' => 'Hadir',
                            ]);

                          
                                Detail_Presensi::where('detail_presensis.id_presensi',$data_detail_presensi['id_presensi'] )
                                ->whereDate('detail_presensis.updated_at',now()->toDateString())
                                ->update([
                                    'status_presensi' => 'Izin', 
                                    'keterangan_presensi'=> $item['keterangan_presensi'],
                                    'updated_at' => Carbon::now()
                                ]);
                           
                        }
                        if($no_telp_orang_tua != null){
                            $client = new \GuzzleHttp\Client([
                                'verify' => 'C:\xampp\php\extras\ssl\cacert.pem'
                            ]);

                            $response = $client->post('https://app.ruangwa.id/api/send_message', [
                                'form_params' => [
                                    'token' => $token,
                                    'number' => $no_telp_orang_tua,
                                    'message' => "Bapak/Ibu Wali dari $nama_siswa,
Status presensi $nama_siswa pada waktu ".Carbon::now()->formatLocalized('%A, %d %B %Y pukul %H:%M')." sebelumnya *$status_presensi* diganti menjadi *$absen* dengan keterangan $keterangan_presensi

*Ini adalah pesan otomatis yang dibuat dari sistem presensi SMKS Kartini Batam*",
                                ],
                            ]);

                            echo $response->getBody();
                        }
                    }else if($status_presensi == 'Alpha'){
                        if($total_alpha_presensi>0){
                            Presensi::where('presensis.nis_siswa',$nis_siswa )
                            ->update([
                                'total_alpha_presensi' => $total_alpha_presensi-1, 
                                'total_izin_presensi' => $total_izin_presensi+1, 
                                'status_presensi' => 'Izin',
                            ]);
                    
                                Detail_Presensi::where('detail_presensis.id_presensi',$data_detail_presensi['id_presensi'] )
                                ->whereDate('detail_presensis.updated_at',now()->toDateString())
                                ->update([
                                    'status_presensi' => 'Izin', 
                                    'keterangan_presensi'=> $item['keterangan_presensi'],
                                    'updated_at' => Carbon::now()
                                ]);
                         
                        }else{
                            Presensi::where('presensis.nis_siswa',$nis_siswa )
                            ->update([
                                'total_izin_presensi'=> $total_izin_presensi+1,
                                'status_presensi' => 'Hadir',
                            ]);
           
                                Detail_Presensi::where('detail_presensis.id_presensi',$data_detail_presensi['id_presensi'] )
                                ->whereDate('detail_presensis.updated_at',now()->toDateString())
                                ->update([
                                    'status_presensi' => 'Izin', 
                                    'keterangan_presensi'=> $item['keterangan_presensi'],
                                    'updated_at' => Carbon::now()
                                ]);
                          
                        }
                        if($no_telp_orang_tua != null){
                            $client = new \GuzzleHttp\Client([
                                'verify' => 'C:\xampp\php\extras\ssl\cacert.pem'
                            ]);

                            $response = $client->post('https://app.ruangwa.id/api/send_message', [
                                'form_params' => [
                                    'token' => $token,
                                    'number' => $no_telp_orang_tua,
                                    'message' => "Bapak/Ibu Wali dari $nama_siswa,
Status presensi $nama_siswa pada waktu ".Carbon::now()->formatLocalized('%A, %d %B %Y pukul %H:%M')." sebelumnya *$status_presensi* diganti menjadi *$absen* dengan keterangan $keterangan_presensi

*Ini adalah pesan otomatis yang dibuat dari sistem presensi SMKS Kartini Batam*",
                                ],
                            ]);

                            echo $response->getBody();
                        }
                    }else if($status_presensi == 'Izin'){
                        Presensi::where('presensis.nis_siswa',$nis_siswa )
                        ->update([
                            'status_presensi' => 'Izin',
                            'updated_at' => Carbon::today()
                        ]);
                        Detail_Presensi::where('detail_presensis.id_presensi',$data_detail_presensi['id_presensi'] )
                                ->whereDate('detail_presensis.updated_at',now()->toDateString())
                                ->update([
                                    'status_presensi' => 'Izin', 
                                    'keterangan_presensi'=> $item['keterangan_presensi'],
                                    'updated_at' => Carbon::now()
                                ]);
                    }else if($status_presensi == 'Belum Absen'){
                        Presensi::where('presensis.nis_siswa',$nis_siswa )
                        ->update([
                            'total_izin_presensi'=> $total_izin_presensi+1,
                            'status_presensi' => 'Izin',
                            'updated_at' => Carbon::today()
                        ]);
                        $keterangan = Detail_Presensi::insert($data_detail_presensi);
                        if($no_telp_orang_tua != null){
                        $client = new \GuzzleHttp\Client([
                            'verify' => 'C:\xampp\php\extras\ssl\cacert.pem'
                        ]);

                        $response = $client->post('https://app.ruangwa.id/api/send_message', [
                                'form_params' => [
                                    'token' => $token,
                                    'number' => $no_telp_orang_tua,
                                    'message' => "Bapak/Ibu Wali dari $nama_siswa,
Status presensi $nama_siswa pada waktu ".Carbon::now()->formatLocalized('%A, %d %B %Y pukul %H:%M')." adalah *$absen* dengan keterangan $keterangan_presensi

*Ini adalah pesan otomatis yang dibuat dari sistem presensi SMKS Kartini Batam*",
                                ],
                            ]);

                            echo $response->getBody();
                        }
                    }
                }
            }

            if($absen == 'alpha'){
                if(Carbon::parse($hari_absen)->notEqualTo(Carbon::parse($hari_ini))){
                    Presensi::where('presensis.nis_siswa',$nis_siswa )
                        ->update([
                            'total_alpha_presensi' => $total_alpha_presensi+1, 
                            'status_presensi' => 'Alpha',
                            'updated_at' => Carbon::today()
                        ]);
                    $keterangan = Detail_Presensi::insert($data_detail_presensi);if($no_telp_orang_tua != null){
                        $client = new \GuzzleHttp\Client([
                            'verify' => 'C:\xampp\php\extras\ssl\cacert.pem'
                        ]);

                        $response = $client->post('https://app.ruangwa.id/api/send_message', [
                            'form_params' => [
                                'token' => $token,
                                'number' => $no_telp_orang_tua,
                                'message' => "Bapak/Ibu Wali dari $nama_siswa,
Status presensi $nama_siswa pada waktu ".Carbon::now()->formatLocalized('%A, %d %B %Y pukul %H:%M')." adalah *$absen*

*Ini adalah pesan otomatis yang dibuat dari sistem presensi SMKS Kartini Batam*",
                            ],
                        ]);

                        echo $response->getBody();
                    }
                }else if(Carbon::parse($hari_absen)->equalTo(Carbon::parse($hari_ini))){
                    if($status_presensi == 'Hadir'){
                        if($total_hadir_presensi>0){
                            Presensi::where('presensis.nis_siswa',$nis_siswa )
                            ->update([
                                'total_hadir_presensi' => $total_hadir_presensi-1, 
                                'total_alpha_presensi' => $total_alpha_presensi+1, 
                                'status_presensi' => 'Alpha',
                            ]);
                        
                                Detail_Presensi::where('detail_presensis.id_presensi',$data_detail_presensi['id_presensi'] )
                                ->whereDate('detail_presensis.updated_at',now()->toDateString())
                                ->update([
                                    'status_presensi' => 'Alpha', 
                                    'keterangan_presensi'=> null,
                                    'updated_at' => Carbon::now()
                                ]);
                         
                        }else{
                            Presensi::where('presensis.nis_siswa',$nis_siswa )
                            ->update([
                                'total_izin_presensi'=> $total_izin_presensi+1,
                                'status_presensi' => 'Hadir',
                            ]);
                       
                                Detail_Presensi::where('detail_presensis.id_presensi',$data_detail_presensi['id_presensi'] )
                                ->whereDate('detail_presensis.updated_at',now()->toDateString())
                                ->update([
                                    'status_presensi' => 'Alpha', 
                                    'keterangan_presensi'=> null,
                                    'updated_at' => Carbon::now()
                                ]);
                    
                        }
                        if($no_telp_orang_tua != null){
                            $client = new \GuzzleHttp\Client([
                                'verify' => 'C:\xampp\php\extras\ssl\cacert.pem'
                            ]);

                            $response = $client->post('https://app.ruangwa.id/api/send_message', [
                                'form_params' => [
                                    'token' => $token,
                                    'number' => $no_telp_orang_tua,
                                    'message' => "Bapak/Ibu Wali dari $nama_siswa,
Status presensi $nama_siswa pada waktu ".Carbon::now()->formatLocalized('%A, %d %B %Y pukul %H:%M')." sebelumnya *$status_presensi* diganti menjadi *$absen*

*Ini adalah pesan otomatis yang dibuat dari sistem presensi SMKS Kartini Batam*",
                                ],
                            ]);

                            echo $response->getBody();
                        }
                    }else if($status_presensi == 'Alpha'){          
                            Presensi::where('presensis.nis_siswa',$nis_siswa )
                            ->update([                    
                                'status_presensi' => 'Alpha',
                            ]);
                           
                                Detail_Presensi::where('detail_presensis.id_presensi',$data_detail_presensi['id_presensi'] )
                                ->whereDate('detail_presensis.updated_at',now()->toDateString())
                                ->update([
                                    'status_presensi' => 'Alpha', 
                                    'keterangan_presensi'=> null,
                                    'updated_at' => Carbon::now()
                                ]);
                        
                    }else if($status_presensi == 'Izin'){
                        if($total_izin_presensi>0){
                            Presensi::where('presensis.nis_siswa',$nis_siswa )
                            ->update([
                                'total_izin_presensi' => $total_izin_presensi-1, 
                                'total_alpha_presensi' => $total_alpha_presensi+1, 
                                'status_presensi' => 'Alpha',
                            ]);

                     
                                Detail_Presensi::where('detail_presensis.id_presensi',$data_detail_presensi['id_presensi'] )
                                ->whereDate('detail_presensis.updated_at',now()->toDateString())
                                ->update([
                                    'status_presensi' => 'Alpha', 
                                    'keterangan_presensi'=> null,
                                    'updated_at' => Carbon::now()
                                ]);
                       
                        }else{
                            Presensi::where('presensis.nis_siswa',$nis_siswa )
                            ->update([
                                'total_alpha_presensi'=> $total_alpha_presensi+1,
                                'status_presensi' => 'Alpha',
                            ]);

                        
                                Detail_Presensi::where('detail_presensis.id_presensi',$data_detail_presensi['id_presensi'] )
                                ->whereDate('detail_presensis.updated_at',now()->toDateString())
                                ->update([
                                    'status_presensi' => 'Alpha', 
                                    'keterangan_presensi'=> null,
                                    'updated_at' => Carbon::now()
                                ]);
                 
                        }
                        if($no_telp_orang_tua != null){
                            $client = new \GuzzleHttp\Client([
                                'verify' => 'C:\xampp\php\extras\ssl\cacert.pem'
                            ]);

                            $response = $client->post('https://app.ruangwa.id/api/send_message', [
                                'form_params' => [
                                    'token' => $token,
                                    'number' => $no_telp_orang_tua,
                                    'message' => "Bapak/Ibu Wali dari $nama_siswa,
Status presensi $nama_siswa pada waktu ".Carbon::now()->formatLocalized('%A, %d %B %Y pukul %H:%M')." sebelumnya *$status_presensi* diganti menjadi *$absen*

*Ini adalah pesan otomatis yang dibuat dari sistem presensi SMKS Kartini Batam*",
                                ],
                            ]);

                            echo $response->getBody();
                        }
                    }else if($status_presensi == 'Belum Absen'){
                        Presensi::where('presensis.nis_siswa',$nis_siswa )
                        ->update([
                            'total_alpha_presensi'=> $total_alpha_presensi+1,
                            'status_presensi' => 'Alpha',
                        ]);
                        $keterangan = Detail_Presensi::insert($data_detail_presensi);
                        if($no_telp_orang_tua != null){
                        $client = new \GuzzleHttp\Client([
                            'verify' => 'C:\xampp\php\extras\ssl\cacert.pem'
                        ]);

                        $response = $client->post('https://app.ruangwa.id/api/send_message', [
                                'form_params' => [
                                    'token' => $token,
                                    'number' => $no_telp_orang_tua,
                                    'message' => "Bapak/Ibu Wali dari $nama_siswa,
Status presensi $nama_siswa pada waktu ".Carbon::now()->formatLocalized('%A, %d %B %Y pukul %H:%M')." adalah *$absen* dengan keterangan $keterangan_presensi

*Ini adalah pesan otomatis yang dibuat dari sistem presensi SMKS Kartini Batam*",
                                ],
                            ]);

                            echo $response->getBody();
                        }
                    }
                }
            }    
        }
    }

    public function keteranganPresensiById(Request $request,$nis_siswa){
        $detail_presensi = Detail_Presensi::Join('presensis', 'detail_presensis.id_presensi','=','presensis.id')
            ->select('detail_presensis.*')
            ->where([
                'presensis.nis_siswa' => $nis_siswa,
            ])
            ->whereNotNull('detail_presensis.keterangan_presensi')
            ->get();

        if(count($detail_presensi)>0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $detail_presensi
            ],200);
        }
        return response([
            'message' => 'Empty',
            'data' => null
        ],400);
    }
}