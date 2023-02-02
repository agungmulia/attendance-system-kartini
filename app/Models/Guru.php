<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'gurus';
    protected $primaryKey = 'nip_guru';
    public $incrementing = false;
    protected $keyType = 'string';

    
    protected $fillable = [
        'nip_guru',
        'nama_guru ',
        'alamat_guru',
        'jenis_kelamin_guru',
        'email_guru',
        'no_telp_guru',
        'password_guru'
    ];

    protected $hidden = [
        'password_guru',
    ];
}