<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuatOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'tambah_pelanggan_id',
        'layanan',
        'metode_pembayaran',
        'waktu_pembayaran',
        'metode_pengambilan',
        'total_harga',
        'dp_dibayar', 
        'sisa_harga', 
        'status',
        'cabang_id',
        'user_id',
    ];

    /**
     * Relasi ke model TambahPelanggan (Satu Order dimiliki oleh Satu Pelanggan).
     * Foreign Key: tambah_pelanggan_id
     */
    public function pelanggan()
    {
        return $this->belongsTo(TambahPelanggan::class, 'tambah_pelanggan_id');
    }

    /**
     * Relasi ke model Cabang (Satu Order dibuat di Satu Cabang).
     * Foreign Key: cabang_id
     */
    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'cabang_id');
    }
    
    /**
     * Relasi ke model User (Satu Order dibuat oleh Satu User/Kasir).
     * Foreign Key: user_id
     */
    public function kasir()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

