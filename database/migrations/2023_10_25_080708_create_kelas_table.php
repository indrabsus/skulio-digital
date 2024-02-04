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
        Schema::create('kelas', function (Blueprint $table) {
            $table->uuid('id_kelas');
            $table->string('nama_kelas');
            $table->foreignUuid('id_jurusan')->references('id_jurusan')->on('jurusan')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignUuid('id_user')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignUuid('id_angkatan')->references('id_angkatan')->on('angkatan')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('tingkat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
