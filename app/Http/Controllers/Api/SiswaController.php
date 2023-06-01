<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Siswa;
use App\Models\User;
use App\Models\Presensi;
use Validator;
use App\Models\Keterangan_Absensi;
use App\Models\Detail_Presensi;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\siswaResource;

class SiswaController extends Controller
{
    public function update(Request $request,$nis_siswa)
    {
        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'nis_siswa' => 'required',
            'nama_siswa' => 'required',
            'tempat_lahir_siswa' => 'required',
            'tanggal_lahir_siswa' => 'required',
            'alamat_siswa' => 'required',
            'jenis_kelamin_siswa' => 'required',
            'email_siswa'=>'required',
            'no_telp_siswa'=>'required|numeric',
        ]);
        
        if($validate->fails())
            return response(['message' => $validate->errors()],400);
        
        
        $email_siswa = Siswa::where('siswas.nis_siswa',$nis_siswa )->value('email_siswa');
        $User = User::select('users.*')
            ->where('users.email',$email_siswa )
            ->first();
        $User->email = $updateData['email_siswa'];
        $User->name = $updateData['nama_siswa'];
        $User->save();
        
        $Siswa = Siswa::select('siswas.*')
            ->where('siswas.nis_siswa',$nis_siswa )
            ->first();
        
         // Check if image was given and save on local file system
        if (isset($updateData['foto_siswa'])) {
            if ($Siswa->foto_siswa!=null) {
                    $absolutePath = public_path($Siswa->foto_siswa);
                    File::delete($absolutePath);
            }

            $relativePath  = $this->saveImage($updateData['foto_siswa']);
            $Siswa->foto_siswa = $relativePath; 
        }
        $Siswa->nis_siswa = $updateData['nis_siswa'];
        $Siswa->nama_siswa = $updateData['nama_siswa'];
        $Siswa->tempat_lahir_siswa = $updateData['tempat_lahir_siswa'];
        $Siswa->tanggal_lahir_siswa = $updateData['tanggal_lahir_siswa'];
        $Siswa->alamat_siswa = $updateData['alamat_siswa'];
        $Siswa->kode_kelas = $updateData['kode_kelas'];
        $Siswa->jenis_kelamin_siswa = $updateData['jenis_kelamin_siswa'];
        $Siswa->email_siswa = $updateData['email_siswa'];
        $Siswa->no_telp_orang_tua = $updateData['no_telp_orang_tua'];
        $Siswa->no_telp_siswa = $updateData['no_telp_siswa'];
        $Siswa->password_siswa =bcrypt($updateData['nis_siswa']);
        $Siswa->save();

        $Presensi = Presensi::select('presensis.*')
            ->where('presensis.nis_siswa',$nis_siswa )
            ->first();
        $Presensi->total_hadir_presensi = $updateData['total_hadir_presensi'];
        $Presensi->total_izin_presensi = $updateData['total_izin_presensi'];
        $Presensi->total_alpha_presensi =$updateData['total_alpha_presensi'];
        $Presensi->save();
        return response([
            'message' => 'Ubah data siswa berhasil!',
            'data' =>$Siswa
        ],200);      
    }

    public function searchFilterSiswa(Request $request){
        $query = $request->get('query');
        $Siswa = siswaResource::collection(Siswa::leftJoin('kelas', 'siswas.kode_kelas','=','kelas.kode_kelas')
            ->select('siswas.*','kelas.tingkat_kelas','kelas.jurusan_kelas','kelas.nomor_kelas')
            ->orderBy('siswas.nama_siswa')
            ->where('nama_siswa', 'like', '%'.$query.'%')
            ->orWhere('email_siswa', 'like', '%'.$query.'%')
            ->paginate(10));

        if(count($Siswa)>0){
            return $Siswa;
        }
    }

    public function tahunPresensi(){
        $user_email = Auth::user()->email;
        $Siswa = Siswa::where('email_siswa',$user_email )->value('nis_siswa');
        $created_at = Detail_Presensi::where('detail_presensis.nis_siswa', $Siswa)
            ->pluck('updated_at')
            ->map(function ($date) {
                return $date->format('Y');
            })
            ->groupBy(function ($year) {
                return $year;
            })
            ->keys();

        if ($created_at->count() > 0) {
            return response([
                'message' => 'Mengambil Data Tahun Ajaran Berhasil',
                'data' => $created_at
            ], 200);
        }
    }

    public function PresensiSiswa($tahun){
        $user_email = Auth::user()->email;
        $Siswa = Siswa::where('email_siswa',$user_email )->value('nis_siswa');
        $detail_presensi = Detail_Presensi::select('detail_presensis.*')
            ->where([
                'detail_presensis.nis_siswa' => $Siswa,
            ])
            ->whereYear('detail_presensis.updated_at',$tahun)
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

    public function dataAbsen(){
        $user_email = Auth::user()->email;
        $Siswa = Siswa::join('presensis','siswas.nis_siswa','presensis.nis_siswa')
            ->where('siswas.email_siswa',$user_email )
            ->select('presensis.updated_at','presensis.status_presensi','presensis.total_hadir_presensi','presensis.total_izin_presensi','presensis.total_alpha_presensi')
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

    public function dataIzin(){
        $user_email = Auth::user()->email;
        $Keterangan_absensi = Siswa::join('presensis','siswas.nis_siswa','presensis.nis_siswa')
            ->leftJoin('detail_presensis','presensis.id','detail_presensis.id_presensi')
            ->select('detail_presensis.updated_at','detail_presensis.keterangan_presensi')
            ->where('siswas.email_siswa',$user_email )
            ->whereNotNull('detail_presensis.keterangan_presensi')
            ->get();
        if(count($Keterangan_absensi)>0){
            return response([
                'message' => 'Mengambil Data Siswa Berhasil',
                'data' =>$Keterangan_absensi
            ],200);
        }
        return response([
            'message' => 'Kelas Tidak Ditemukan',
            'data' => null
        ],404);
    }

    public function profilSiswa()
    {
        $user_email = Auth::user()->email;
        $Siswa = Siswa::leftJoin('kelas', 'siswas.kode_kelas', '=', 'kelas.kode_kelas')
            -> select('siswas.*','kelas.tingkat_kelas','kelas.jurusan_kelas','kelas.nomor_kelas')
            ->where('siswas.email_siswa',$user_email )
            ->first();
            
        
        if(!is_null($Siswa)){
            return response([
                'message' => 'Mengambil Data Siswa Berhasil',
                'data' =>new siswaResource($Siswa)
            ],200);
        }
        return response([
            'message' => 'Siswa Tidak Ditemukan',
            'data' => null
        ],404);
    }

    public function updateProfileSiswa(Request $request)
    {
        $user_email = Auth::user()->email;
        $foto_siswa = Siswa::where('siswas.email_siswa',$user_email )->value('foto_siswa');
        $Siswa = Siswa::select('siswas.*')
            ->where('siswas.email_siswa',$user_email )
            ->first();
        if(is_null($Siswa)){
            return response([
                'message' => 'Siswa Not Found',
                'data' => null
            ],404);
        }

        $updateData = $request->all();

        
        $validate = Validator::make($updateData,[
            'no_telp_siswa'=>'numeric'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()],400);

        
         // Check if image was given and save on local file system
        if (isset($updateData['foto_siswa'])) {
            if ($foto_siswa!=null) {
                $absolutePath = public_path($Siswa->foto_siswa);
                File::delete($absolutePath);
            }

            $relativePath  = $this->saveImage($updateData['foto_siswa']);
            $Siswa->foto_siswa = $relativePath; 
        }

        $Siswa->alamat_siswa = $updateData['alamat_siswa'];
        $Siswa->no_telp_siswa = $updateData['no_telp_siswa'];
        
        if($Siswa->save()){
            return response([
                'message' => 'Update Profil Berhasil!',
                'data' => $Siswa
            ],200);
        }

        return response([
            'message' => 'Update Profil Gagal!',
            'data' => null,
        ],400);
    }


    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'nis_siswa' => 'required',
            'nama_siswa' => 'required',
            'tempat_lahir_siswa' => 'required',
            'tanggal_lahir_siswa' => 'required',
            'alamat_siswa' => 'required',
            'jenis_kelamin_siswa' => 'required',
            'email_siswa'=>'required',
            'no_telp_siswa'=>'required|numeric',
        ]);
        
        if($validate->fails())
            return response(['message' => $validate->errors()],400);
        
        
        $Siswa = new Siswa();
        // Check if image was given and save on local file system
        if (isset($storeData['foto_siswa'])) {
            $relativePath  = $this->saveImage($storeData['foto_siswa']);
            $Siswa->foto_siswa = $relativePath; 
        }
        $Siswa->nis_siswa = $storeData['nis_siswa'];
        $Siswa->nama_siswa = $storeData['nama_siswa'];
        $Siswa->tempat_lahir_siswa = $storeData['tempat_lahir_siswa'];
        $Siswa->tanggal_lahir_siswa = $storeData['tanggal_lahir_siswa'];
        $Siswa->alamat_siswa = $storeData['alamat_siswa'];
        $Siswa->kode_kelas = $storeData['kode_kelas'];
        $Siswa->jenis_kelamin_siswa = $storeData['jenis_kelamin_siswa'];
        $Siswa->email_siswa = $storeData['email_siswa'];
        $Siswa->no_telp_orang_tua = $storeData['no_telp_orang_tua'];
        $Siswa->no_telp_siswa = $storeData['no_telp_siswa'];
        $Siswa->password_siswa =bcrypt($storeData['nis_siswa']);
        $Siswa->save();

        $dataUser['email'] = $storeData['email_siswa'];
        $dataUser['name'] = $storeData['nama_siswa'];
        $dataUser['is_admin'] = 3;
        $dataUser['password'] = bcrypt($storeData['nis_siswa']);
        $User = User::create($dataUser);

        $dataAbsensi['nis_siswa'] = $storeData['nis_siswa'];
        $Presensi = Presensi::create($dataAbsensi);
        return response([
            'message' => 'Tambah siswa berhasil!',
            'data' =>$Siswa
        ],200);      
    }

    public function destroy($nis_siswa)
    {
        $Email_siswa = Siswa::where('siswas.nis_siswa',$nis_siswa )->value('email_siswa');
        $Siswa = Siswa::where('siswas.nis_siswa',$nis_siswa )->first();

        $User = User::where('users.email',$Email_siswa )->first();
            
        if(is_null($Siswa)){
            return response([
                'message' => 'Siswa Tidak Ditemukan',
                'data' => null
            ],404);
        }

        if($User->is_admin){
            return response([
                'message' => 'Siswa adalah Admin, Tidak bisa dihapus!',
                'data' => null
            ],404);
        }

        $User->delete();

        if($Siswa->delete()){
            return response([
                'message' => 'Hapus data siswa berhasil!',
                'data' =>$Siswa
            ],200);
        }
       
        return response([
            'message' => 'Hapus data siswa gagal!',
            'data' => null,
        ],400);  
    }

     public function showSiswaByKelas($kode_kelas)
    {
       $Siswa = Siswa::join('presensis', 'siswas.nis_siswa', '=', 'presensis.nis_siswa')
            ->where('siswas.kode_kelas',$kode_kelas )
            ->select('siswas.nis_siswa','siswas.nama_siswa','presensis.updated_at','presensis.status_presensi')
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
        $Siswa = siswaResource::collection(Siswa::leftJoin('kelas', 'siswas.kode_kelas','=','kelas.kode_kelas')
            ->select('siswas.*','kelas.tingkat_kelas','kelas.jurusan_kelas','kelas.nomor_kelas')
            ->orderBy('siswas.nama_siswa')
            ->paginate(10));

        if(count($Siswa)>0){
            return $Siswa;
        }
        return response([
            'message' => 'Empty',
            'data' => null
        ],400);
    }

    private function saveImage($image)
    {
        // Check if image is valid base64 string
        if (preg_match('/^data:image\/(\w+);base64,/', $image, $type)) {
            // Take out the base64 encoded text without mime type
            $image = substr($image, strpos($image, ',') + 1);
            // Get file extension
            $type = strtolower($type[1]); // jpg, png, gif

            // Check if file is an image
            if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
                throw new \Exception('invalid image type');
            }
            $image = str_replace(' ', '+', $image);
            $image = base64_decode($image);

            if ($image === false) {
                throw new \Exception('base64_decode failed');
            }
        } else {
            throw new \Exception('did not match data URI with image data');
        }

        $dir = 'images/';
        $file = Str::random() . '.' . $type;
        $absolutePath = public_path($dir);
        $relativePath = $dir . $file;
        if (!File::exists($absolutePath)) {
            File::makeDirectory($absolutePath, 0755, true);
        }
        file_put_contents($relativePath, $image);

        return $relativePath;
    }

    public function show($nis_siswa){
        $Siswa = Siswa::leftJoin('kelas', 'siswas.kode_kelas', '=', 'kelas.kode_kelas')
                    ->leftJoin('presensis', 'siswas.nis_siswa', '=', 'presensis.nis_siswa')
                    ->select('siswas.*','kelas.tingkat_kelas','kelas.jurusan_kelas','kelas.nomor_kelas','presensis.total_hadir_presensi','presensis.total_izin_presensi','presensis.total_alpha_presensi')
                    ->where('siswas.nis_siswa',$nis_siswa )
                    ->first();
        if(!is_null($Siswa)){
            return response([
                'message' => 'Mengambil Data Siswa Berhasil',
                'data' =>new siswaResource($Siswa)
            ],200);
        }
        return response([
            'message' => 'Siswa Tidak Ditemukan',
            'data' => null
        ],404);
    }
}