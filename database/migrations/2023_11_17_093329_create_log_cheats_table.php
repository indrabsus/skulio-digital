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
        Schema::create('log_cheats', function (Blueprint $table) {
            $table->uuid('id_logc')->primary();
            $table->foreignUuid('id_ujian')->references('id_ujian')->on('ujian')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignUuid('id_siswa')->references('id_siswa')->on('data_siswa')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_cheats');
    }
};
