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
        Schema::create('jawaban_siswa', function (Blueprint $table) {
            $table->uuid('id_jawabansiswa')->primary();
            $table->foreignUuid(column: 'id_sumatif')->references('id_sumatif')->on('sumatif')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignUuid(column: 'id_soal')->references('id_soal')->on('soal')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignUuid(column: 'id_user')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('jawaban');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban_siswas');
    }
};
