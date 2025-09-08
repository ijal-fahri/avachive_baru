<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TambahPelanggan extends Model
{
    use HasFactory;
    
    protected $fillable = ['nama',
        'no_handphone',
        'provinsi',
        'provinsi_id',
        'kota',
        'kota_id',
        'kecamatan',
        'kecamatan_id',
        'desa',
        'desa_id',
        'kodepos',
        'detail_alamat'
        ,'cabang_id'];

    /**
     * Relasi ke model BuatOrder (Satu Pelanggan memiliki Banyak Order).
     */
    public function riwayatOrder()
    {
        return $this->hasMany(BuatOrder::class, 'tambah_pelanggan_id');
    }

    /**
     * Relasi ke model Cabang (Satu Pelanggan terdaftar di Satu Cabang).
     */
    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'cabang_id');
    }
}

