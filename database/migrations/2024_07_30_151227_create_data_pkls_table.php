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
        Schema::create('data_pkl', function (Blueprint $table) {
            $table->uuid('id_pkl')->primary();
            $table->foreignUuid('id_siswa')->references('id_siswa')->on('data_siswa')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignUuid('id_pembimbing')->references('id_data')->on('data_user')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignUuid('id_observer')->references('id_data')->on('data_user')->onUpdate('cascade')->onDelete('cascade');
            $table->date('waktu_mulai');
            $table->date('waktu_selesai');
            $table->bigInteger('tahun');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_pkls');
    }
};
