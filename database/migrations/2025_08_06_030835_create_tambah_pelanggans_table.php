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

        // Add user_id column and foreign key constraint
        Schema::table('tambah_pelanggans', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->after('id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tambah_pelanggans', function (Blueprint $table) {
            // Drop foreign key constraint and user_id column
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        Schema::dropIfExists('tambah_pelanggans');
    }
};
