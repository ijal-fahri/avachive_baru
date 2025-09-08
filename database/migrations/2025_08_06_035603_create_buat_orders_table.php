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
        Schema::create('buat_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tambah_pelanggan_id')->constrained('tambah_pelanggans')->onDelete('cascade');
            $table->json('layanan'); // Untuk menyimpan detail layanan yang dipesan (nama, harga, kuantitas)
            $table->string('metode_pembayaran');
            $table->string('waktu_pembayaran');
            $table->string('metode_pengambilan');
            $table->integer('total_harga');
            $table->integer('dp_dibayar')->nullable()->default(0); // Kolom untuk DP
            $table->integer('sisa_harga')->nullable()->default(0); // Kolom untuk sisa bayar
            $table->string('status')->default('Diproses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buat_orders');
    }
};