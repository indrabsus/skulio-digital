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
        Schema::create('ujian', function (Blueprint $table) {
            $table->uuid('id_ujian')->primary();
            $table->string('nama_ujian');
            $table->string('link');
            $table->bigInteger('waktu');
            $table->bigInteger('token');
            $table->enum('acc', ['y','n']);
            $table->foreignUuid('id_kelas')->references('id_kelas')->on('kelas')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ujian');
    }
};
