<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;
    protected $fillable = [
        'nis_siswa',
        'total_hadir_presensi',
        'status_presensi',
        'total_izin_presensi',
        'total_alpha_presensi',
    ];
}