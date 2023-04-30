<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_Presensi extends Model
{
    use HasFactory;
    protected $table = 'detail_presensis';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_presensi',
        'status_presensi',
        'keterangan_izin_presensi',
    ];
}