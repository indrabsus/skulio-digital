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
        Schema::create('daftar_peminjam_buku', function (Blueprint $table) {
            $table->id("id_daftar");
            $table->foreignId('id_peminjam')->references('id_peminjam')->on('data_peminjam')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('id_siswa')->references('id_siswa')->on('data_siswa')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daftar_peminjam_buku');
    }
};
