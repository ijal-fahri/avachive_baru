<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_cabang',
        'alamat',
        'no_whatsapp', // Pastikan ini sesuai dengan kolom di tabel
    ];

    /**
     * Relasi ke model BuatOrder (Satu Cabang memiliki Banyak Order).
     */
    public function semuaOrder()
    {
        return $this->hasMany(BuatOrder::class, 'cabang_id');
    }

    /**
     * Relasi ke model User (Satu Cabang memiliki Banyak Karyawan).
     */
    public function karyawan()
    {
        return $this->hasMany(User::class, 'cabang_id');
    }
}