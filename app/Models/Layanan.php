<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    // Tidak perlu 'use HasFactory;' jika tidak digunakan
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'paket',
        'kategori',
        'harga',
        'satuan',
        'cabang_id', // <-- INI YANG DITAMBAHKAN
    ];
}