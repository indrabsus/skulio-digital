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
        Schema::create('log_ujian2', function (Blueprint $table) {
            $table->uuid('id_log')->primary();
            $table->foreignUuid('id_kelassumatif')->references('id_kelassumatif')->on('kelas_sumatif')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignUuid('id_user')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('status', ['proses','done']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_ujian2s');
    }
};
