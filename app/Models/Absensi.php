<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

        protected $fillable = [
        'nis_siswa',
        'hadir_absensi ',
        'status_absensi',
        'izin_absensi',
        'alpha_absensi',
    
    ];
}