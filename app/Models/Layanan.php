<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    use HasFactory;

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
        'diskon', // Ditambahkan agar fitur diskon berfungsi
        'satuan', // Sesuai model yang Anda berikan
        'cabang_id',
    ];

    /**
     * Relasi ke model Cabang.
     */
    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }
}