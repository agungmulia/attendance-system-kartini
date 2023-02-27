<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'gurus';
    protected $primaryKey = 'nip_guru';
    public $incrementing = false;
    protected $keyType = 'string';

    
    protected $fillable = [
        'nip_guru',
        'nama_guru',
        'alamat_guru',
        'jenis_kelamin_guru',
        'email_guru',
        'no_telp_guru',
        'password_guru',
        'foto_guru'
    ];

    protected $hidden = [
        'password_guru',
    ];

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