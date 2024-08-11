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
        Schema::create('nilai_ujian', function (Blueprint $table) {
            $table->uuid('id_nilaiujian')->primary();
            $table->foreignUuid('id_kelassumatif')->references('id_kelassumatif')->on('kelas_sumatif')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignUuid('id_user_siswa')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('nilai_ujian');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_ujians');
    }
};
