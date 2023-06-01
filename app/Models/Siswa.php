<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswas';
    protected $primaryKey = 'nis_siswa';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nis_siswa',
        'nama_siswa ',
        'alamat_siswa',
        'jenis_kelamin_siswa',
        'email_siswa',
        'no_telp_orang_tua',
        'no_telp_siswa',
        'password_siswa',
        'foto_siswa'
    ];

    protected $hidden = [
        'password_siswa',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function getCreatedAtAttribute(){
        if(!is_null($this->attributes['created_at'])){
            return Carbon::parse($this->attributes['created_at'])->format('Y-m-d H:i:s');
        }
    }
    
    public function getUpdatedAtAttribute(){
        if(!is_null($this->attributes['updated_at'])){
            return Carbon::parse($this->attributes['updated_at'])->format('Y-m-d H:i:s');
        }
    }
}