<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('layanans', function (Blueprint $table) {
            // Kolom dari migrasi awal Anda
            $table->id();
            $table->string('nama');
            $table->string('paket');
            $table->text('deskripsi')->nullable(); // Kolom ini dipertahankan
            $table->integer('harga');

            // Kolom baru yang ditambahkan untuk fungsionalitas
            $table->string('kategori'); 
            $table->unsignedTinyInteger('diskon')->default(0);
            $table->string('satuan')->nullable();
            
            // Kolom kunci untuk menghubungkan ke cabang
            $table->foreignId('cabang_id')->constrained('cabangs')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layanans');
    }
};