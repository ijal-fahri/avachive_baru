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
        Schema::create('tambah_pelanggans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('no_handphone');
            
            // Columns for region names (as you had)
            $table->string('provinsi'); 
            $table->string('kota'); 
            $table->string('kecamatan');
            $table->string('desa')->nullable();

            // NEW: Columns for region IDs from the API
            $table->string('provinsi_id')->nullable();
            $table->string('kota_id')->nullable();
            $table->string('kecamatan_id')->nullable();
            $table->string('desa_id')->nullable();
            
            $table->string('kodepos'); 
            $table->text('detail_alamat'); 
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tambah_pelanggans');
    }
};
