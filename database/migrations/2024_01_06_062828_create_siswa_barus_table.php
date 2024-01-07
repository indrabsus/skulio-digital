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
        Schema::create('siswa_baru', function (Blueprint $table) {
            $table->id('id_siswa_baru');
            $table->foreignId('id_siswa')->references('id_siswa')->on('siswa_ppdb')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('id_kelas')->references('id_kelas')->on('kelas_ppdb')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa_barus');
    }
};
