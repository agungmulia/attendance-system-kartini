<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;


    protected $fillable = [
        'nis_siswa',
        'nama_siswa ',
        'alamat_siswa',
        'jenis_kelamin_siswa',
        'email_siswa',
        'no_telp_siswa',
        'password_siswa'
    ];

    protected $hidden = [
        'password_siswa',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}