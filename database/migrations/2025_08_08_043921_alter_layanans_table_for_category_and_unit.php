<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Perintah ini akan dijalankan saat kamu ketik 'php artisan migrate'.
     */
    public function up(): void
    {
        Schema::table('layanans', function (Blueprint $table) {
            // 1. Mengubah nama kolom 'deskripsi' menjadi 'kategori'
            $table->renameColumn('deskripsi', 'kategori');
            
            // 2. Menambah kolom baru 'satuan' setelah kolom 'harga'
            $table->string('satuan')->after('harga')->default('Kiloan');
        });
    }

    /**
     * Reverse the migrations.
     * Perintah ini untuk membatalkan migrasi jika diperlukan.
     */
    public function down(): void
    {
        Schema::table('layanans', function (Blueprint $table) {
            // 1. Mengembalikan nama kolom 'kategori' menjadi 'deskripsi'
            $table->renameColumn('kategori', 'deskripsi');
            
            // 2. Menghapus kolom 'satuan'
            $table->dropColumn('satuan');
        });
    }
};