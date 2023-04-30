<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Keterangan_Absensi extends Model
{
    use HasFactory;


    protected $table = 'keterangan_absensis';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_absensi',
        'keterangan_absensi',
    ];


    public function getCreatedAtAttribute(){
        if(!is_null($this->attributes['created_at'])){
            return Carbon::parse($this->attributes['created_at'])->format('Y-m-d');
        }
    }
    
    public function getUpdatedAtAttribute(){
        if(!is_null($this->attributes['updated_at'])){
            return Carbon::parse($this->attributes['updated_at'])->format('Y-m-d');
        }
    }
}