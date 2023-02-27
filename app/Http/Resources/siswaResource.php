<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;
class siswaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'nis_siswa' => $this->nis_siswa,
            'foto_siswa_url' => $this->foto_siswa ? URL::to($this->foto_siswa) : null,
            'nama_siswa' => $this->nama_siswa,
            'tempat_lahir_siswa' => $this->tempat_lahir_siswa,
            'tanggal_lahir_siswa' => $this->tanggal_lahir_siswa,
            'tingkat_kelas' => $this->tingkat_kelas,
            'jurusan_kelas' => $this->jurusan_kelas,
            'nomor_kelas' => $this->nomor_kelas,
            'kode_kelas' => $this->kode_kelas,
            'alamat_siswa' => $this->alamat_siswa,
            'jenis_kelamin_siswa' => $this->jenis_kelamin_siswa,
            'email_siswa' => $this->email_siswa,
            'no_telp_siswa' => $this->no_telp_siswa,
            'hadir_absensi' => $this->hadir_absensi,
            'izin_absensi' => $this->izin_absensi,
            'alpha_absensi' => $this->alpha_absensi,
            'created_at' => (new \DateTime($this->created_at))->format('Y-m-d H:i:s'),
            'updated_at' => (new \DateTime($this->updated_at))->format('Y-m-d H:i:s'),
        ];
    }
}