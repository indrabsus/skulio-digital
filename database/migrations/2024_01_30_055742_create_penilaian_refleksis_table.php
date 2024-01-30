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
        Schema::create('penilaian_refleksi', function (Blueprint $table) {
            $table->id('id_penilaian');
            $table->foreignId('id_jawaban')->references('id_jawaban')->on('jwbn_refleksi')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('nilai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_refleksis');
    }
};
