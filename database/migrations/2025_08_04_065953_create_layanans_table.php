<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('layanans', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->string('paket');
        $table->text('deskripsi')->nullable();
        $table->integer('harga'); // dalam rupiah
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
