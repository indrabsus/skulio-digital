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
        Schema::create('sumatif', function (Blueprint $table) {
            $table->uuid('id_sumatif');
            $table->foreignUuid('id_kelas')->references('id_kelas')->on('kelas')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignUuid('id_soalujian')->references('id_soalujian')->on('soal_ujian')->onUpdate('cascade')->onDelete('cascade');
            $table->string('nama_sumatif');
            $table->string('token');
            $table->bigInteger('waktu');
            $table->bigInteger('tahun');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sumatifs');
    }
};
