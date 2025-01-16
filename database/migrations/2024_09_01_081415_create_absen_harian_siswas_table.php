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
        Schema::create('absen_harian_siswa', function (Blueprint $table) {
            $table->uuid('id_harian')->primary();
            $table->foreignUuid('id_siswa')->references('id_siswa')->on('data_siswa')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('status', [0,1,2,3,4]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absen_harian_siswas');
    }
};
