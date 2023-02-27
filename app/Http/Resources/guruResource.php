<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class guruResource extends JsonResource
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
            'nip_guru' => $this->nip_guru,
            'foto_guru_url' => $this->foto_guru ? URL::to($this->foto_guru) : null,
            'nama_guru' => $this->nama_guru,
            'tempat_lahir_guru' => $this->tempat_lahir_guru,
            'tanggal_lahir_guru' => $this->tanggal_lahir_guru,
            'tingkat_kelas' => $this->tingkat_kelas,
            'jurusan_kelas' => $this->jurusan_kelas,
            'nomor_kelas' => $this->nomor_kelas,
            'kode_kelas' => $this->kode_kelas,
            'alamat_guru' => $this->alamat_guru,
            'jenis_kelamin_guru' => $this->jenis_kelamin_guru,
            'email_guru' => $this->email_guru,
            'no_telp_guru' => $this->no_telp_guru,
            'created_at' => (new \DateTime($this->created_at))->format('Y-m-d H:i:s'),
            'updated_at' => (new \DateTime($this->updated_at))->format('Y-m-d H:i:s'),
        ];
    }
}