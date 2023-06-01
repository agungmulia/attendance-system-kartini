<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use Carbon\Carbon;
use App\Models\Guru;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Http\Resources\guruResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class GuruController extends Controller
{
    public function update(Request $request,$nip_guru)
    {
        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'nip_guru' => 'required',
            'nama_guru' => 'required',
            'alamat_guru' => 'required',
            'jenis_kelamin_guru' => 'required',
            'email_guru'=>'required',
            'no_telp_guru'=>'required|numeric',
        ]);
        
        if($validate->fails())
            return response(['message' => $validate->errors()],400);

        $wali_kelas = Kelas::where('kelas.nip_guru',$nip_guru )->value('nip_guru');
        if($wali_kelas==null){
            Kelas::where('kelas.kode_kelas',$updateData['kode_kelas'] )
            ->update([
                'nip_guru' => $updateData['nip_guru'],
                'updated_at' => Carbon::today()
            ]);
        }else{
            Kelas::where('kelas.nip_guru',$nip_guru )
            ->update([
                'nip_guru' => null,
                'updated_at' => Carbon::today()
            ]);
            Kelas::where('kelas.kode_kelas',$updateData['kode_kelas'] )
            ->update([
                'nip_guru' => $updateData['nip_guru'],
                'updated_at' => Carbon::today()
            ]);
        }
            
        $email_guru = Guru::where('gurus.nip_guru',$nip_guru )->value('email_guru');
        $User = User::select('users.*')
            ->where('users.email',$email_guru )
            ->first();
        $User->email = $updateData['email_guru'];
        $User->name = $updateData['nama_guru'];
        $User->save();
        
        $Guru = Guru::select('gurus.*')
            ->where('gurus.nip_guru',$nip_guru )
            ->first();
        if ($Guru->foto_guru!=null && isset($updateData['foto_guru'])) {
                $absolutePath = public_path($Guru->foto_guru);
                File::delete($absolutePath);
        }
         // Check if image was given and save on local file system
        if (isset($updateData['foto_guru'])) {
            $relativePath  = $this->saveImage($updateData['foto_guru']);
            $Guru->foto_guru = $relativePath; 
        }
        $Guru->nip_guru = $updateData['nip_guru'];
        $Guru->nama_guru = $updateData['nama_guru'];
        $Guru->tempat_lahir_guru = $updateData['tempat_lahir_guru'];
        $Guru->tanggal_lahir_guru = $updateData['tanggal_lahir_guru'];
        $Guru->alamat_guru = $updateData['alamat_guru'];
        $Guru->jenis_kelamin_guru = $updateData['jenis_kelamin_guru'];
        $Guru->email_guru = $updateData['email_guru'];
        $Guru->no_telp_guru = $updateData['no_telp_guru'];
        $Guru->save();
        if($Guru->save()){
            return response([
                'message' => 'Update data guru berhasil!',
                'data' =>$Guru
            ],200);      
        }    
    }

    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'nip_guru' => 'required',
            'nama_guru' => 'required',
            'alamat_guru' => 'required',
            'jenis_kelamin_guru' => 'required',
            'email_guru'=>'required',
            'no_telp_guru'=>'required|numeric',
        ]);
        
        if($validate->fails())
            return response(['message' => $validate->errors()],400);

        $Guru = new Guru();
        // Check if image was given and save on local file system
        if (isset($storeData['foto_guru'])) {
            $relativePath  = $this->saveImage($storeData['foto_guru']);
            $Guru->foto_guru = $relativePath; 
        }
        $Guru->nip_guru = $storeData['nip_guru'];
        $Guru->nama_guru = $storeData['nama_guru'];
        $Guru->tempat_lahir_guru = $storeData['tempat_lahir_guru'];
        $Guru->tanggal_lahir_guru = $storeData['tanggal_lahir_guru'];
        $Guru->alamat_guru = $storeData['alamat_guru'];
        $Guru->jenis_kelamin_guru = $storeData['jenis_kelamin_guru'];
        $Guru->email_guru = $storeData['email_guru'];
        $Guru->no_telp_guru = $storeData['no_telp_guru'];
        $Guru->password_guru =bcrypt($storeData['nip_guru']);
        $Guru->save();
        
        Kelas::where('kelas.kode_kelas',$storeData['kode_kelas'] )
                ->update([
                    'nip_guru' => $storeData['nip_guru'],
                    'updated_at' => Carbon::today()
                ]);
        $dataUser['email'] = $storeData['email_guru'];
        $dataUser['name'] = $storeData['nama_guru'];
        $dataUser['password'] = bcrypt($storeData['nip_guru']);
        $User = User::create($dataUser);
        return response([
            'message' => 'Add Guru Success',
            'data' =>$Guru
        ],200);      
    }

    public function index()
    {
         $GuruData = Guru::leftJoin('kelas', 'gurus.nip_guru','=','kelas.nip_guru')
            ->select('gurus.*','kelas.tingkat_kelas','kelas.jurusan_kelas','kelas.nomor_kelas')
            ->orderBy('gurus.nama_guru')
            ->paginate(10);
        $Guru = GuruResource::collection($GuruData);

        if(count($Guru)>0){
            return $Guru;
        }
        return response([
            'message' => 'Empty',
            'data' => null
        ],400);
    }

    public function updateProfile(Request $request)
    {
        $user_email = Auth::user()->email;
        $foto_guru = Guru::where('gurus.email_guru',$user_email )->value('foto_guru');
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
            'no_telp_guru'=>'numeric'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()],400);
  
         // Check if image was given and save on local file system
        if (isset($updateData['foto_guru'])) {
            if ($foto_guru!=null) {
                $absolutePath = public_path($Guru->foto_guru);
                File::delete($absolutePath);
            }
            $relativePath  = $this->saveImage($updateData['foto_guru']);
            $Guru->foto_guru = $relativePath; 
        }
        $Guru->alamat_guru = $updateData['alamat_guru'];
        $Guru->no_telp_guru = $updateData['no_telp_guru'];
        
        if($Guru->save()){
            return response([
                'message' => 'Update Profil Berhasil!',
                'data' => $Guru
            ],200);
        }
        return response([
            'message' => 'Update Profil Gagal!',
            'data' => null,
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

    public function show()
    {
        $user_email = Auth::user()->email;
        $nip_guru = Guru::where('email_guru', $user_email)->value('nip_guru');
        $Guru = Guru::leftJoin('kelas', 'gurus.nip_guru', '=', 'kelas.nip_guru')
            -> select('gurus.*','kelas.tingkat_kelas','kelas.jurusan_kelas','kelas.nomor_kelas')
            ->where('gurus.email_guru',$user_email )
            ->first();
            
        
        if(!is_null($Guru)){
            return response([
                'message' => 'Mengambil Data Guru Berhasil',
                'data' =>new guruResource($Guru)
            ],200);
        }
        return response([
            'message' => 'Guru Tidak Ditemukan',
            'data' => null
        ],404);
    }

    public function searchFilterGuru(Request $request){
        $query = $request->get('query');
        $GuruData = Guru::leftJoin('kelas', 'gurus.nip_guru','=','kelas.nip_guru')
            ->select('gurus.*','kelas.tingkat_kelas','kelas.jurusan_kelas','kelas.nomor_kelas')
            ->orderBy('gurus.nama_guru')
            ->where('nama_guru', 'like', '%'.$query.'%')
            ->orWhere('email_guru', 'like', '%'.$query.'%')
            ->paginate(10);
        $Guru = GuruResource::collection($GuruData);
        
        if(count($Guru)>0){
            return $Guru;
        }
    }

    public function cariGuru($nip_guru)
    {
        $Guru = Guru::leftJoin('kelas', 'gurus.nip_guru', '=', 'kelas.nip_guru')
            -> select('gurus.*','kelas.kode_kelas','kelas.tingkat_kelas','kelas.jurusan_kelas','kelas.nomor_kelas')
            ->where('gurus.nip_guru',$nip_guru )
            ->first();
            
        
        if(!is_null($Guru)){
            return response([
                'message' => 'Mengambil Data Guru Berhasil',
                'data' =>new guruResource($Guru)
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
        $Kelas = Kelas::where('nip_guru' , $Guru )->value('kode_kelas');
        $Siswa = Siswa::join('presensis','siswas.nis_siswa','presensis.nis_siswa')
            ->where('siswas.kode_kelas',$Kelas )
            ->select('siswas.nis_siswa','siswas.nama_siswa','presensis.total_hadir_presensi','presensis.total_izin_presensi','presensis.total_alpha_presensi')
            ->get();
        if(count($Siswa)>0){
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

    public function cariPresensiKelas($tanggal){
        $user_email = Auth::user()->email;
        $Guru = Guru::where('email_guru',$user_email )->value('nip_guru');
        $Kelas = Kelas::where('nip_guru' , $Guru )->value('kode_kelas');
        $Siswa = Siswa::join('detail_presensis','siswas.nis_siswa','detail_presensis.nis_siswa')
            ->where('siswas.kode_kelas',$Kelas )
            ->whereDate('detail_presensis.updated_at',$tanggal)
            ->select('siswas.nis_siswa','siswas.nama_siswa','detail_presensis.*')
            ->get();
        if(count($Siswa)>0){
            return response([
                'message' => 'Mengambil Data Presensi Kelas Berhasil',
                'data' =>$Siswa
            ],200);
        }
        return response([
            'message' => 'Presensi Tidak Ditemukan',
            'data' => null
        ],404);
    }

    public function cariPresensiSiswa($tanggal){
        $user_email = Auth::user()->email;
        $Guru = Guru::where('email_guru',$user_email )->value('nip_guru');
        $Kelas = Kelas::where('nip_guru' , $Guru )->value('kode_kelas');
        $Siswa = Siswa::join('detail_presensis','siswas.nis_siswa','detail_presensis.nis_siswa')
            ->where('siswas.kode_kelas',$Kelas )
            ->whereDate('detail_presensis.updated_at',$tanggal)
            ->select('siswas.nis_siswa','siswas.nama_siswa','detail_presensis.*')
            ->get();
        if(count($Siswa)>0){
            return response([
                'message' => 'Mengambil Data Presensi Kelas Berhasil',
                'data' =>$Siswa
            ],200);
        }
        return response([
            'message' => 'Presensi Tidak Ditemukan',
            'data' => null
        ],404);
    }

    public function destroy($nip_guru)
    {
        $Email_Guru = Guru::where('gurus.nip_guru',$nip_guru )->value('email_guru');
        $Guru = Guru::where('gurus.nip_guru',$nip_guru )->first();

        Kelas::where('kelas.nip_guru',$nip_guru )
                ->update([
                    'nip_guru' => null,
                    'updated_at' => Carbon::today()
                ]);

        $User = User::where('users.email',$Email_Guru )
            ->first();
            
        if(is_null($Guru)){
            return response([
                'message' => 'Guru Tidak Ditemukan',
                'data' => null
            ],404);
        }

        if($User->is_admin){
            return response([
                'message' => 'Guru adalah Admin, Tidak bisa dihapus!',
                'data' => null
            ],404);
        }

        $User->delete();

        if($Guru->delete()){
            return response([
                'message' => 'Hapus Guru Berhasil',
                'data' =>$Guru
            ],200);
        }
       
        return response([
            'message' => 'Hapus Guru Gagal',
            'data' => null,
        ],400);  
    }
}