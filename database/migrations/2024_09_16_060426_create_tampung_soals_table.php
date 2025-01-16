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
        Schema::create('tampung_soal', function (Blueprint $table) {
            $table->uuid('id_tampung')->primary();
            $table->foreignUuid(column: 'id_soal')->references('id_soal')->on('soal')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignUuid(column: 'id_soalujian')->references('id_soalujian')->on('soal_ujian')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tampung_soals');
    }
};
