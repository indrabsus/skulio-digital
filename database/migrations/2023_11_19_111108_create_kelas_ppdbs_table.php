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
        Schema::create('kelas_ppdb', function (Blueprint $table) {
            $table->uuid('id_kelas');
            $table->string('nama_kelas');
            $table->foreignUuid('id_jurusan')->references('id_jurusan')->on('jurusan_ppdb')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('max');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas_ppdb');
    }
};
