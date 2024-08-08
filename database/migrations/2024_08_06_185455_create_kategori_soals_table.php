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
        Schema::create('kategori_soal', function (Blueprint $table) {
            $table->uuid('id_kategori')->primary();
            $table->foreignUuid('id_mapel')->references('id_mapel')->on('mata_pelajaran')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignUuid('id_user')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('kelas',[10,11,12]);
            $table->string('nama_kategori');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategori_soals');
    }
};
