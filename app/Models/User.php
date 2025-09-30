<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email', // <-- TAMBAHKAN BARIS INI
        'password',
        'plain_password', // <-- Pastikan ini juga ada
        'usertype',       // <-- Pastikan ini juga ada
        'profile_photo',
        'cabang_id',      // <-- Jika Anda menggunakan ini saat create, tambahkan juga
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        // 'plain_password' DIHAPUS DARI SINI
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    
    // Relasi-relasi tetap sama...
    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'cabang_id');
    }

    public function pelanggan()
    {
        return $this->hasOne(TambahPelanggan::class, 'user_id');
    }
}

