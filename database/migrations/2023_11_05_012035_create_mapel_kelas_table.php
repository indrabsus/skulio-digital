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
        Schema::create('mapel_kelas', function (Blueprint $table) {
            $table->uuid('id_mapelkelas');
            $table->foreignUuid('id_mapel')->references('id_mapel')->on('mata_pelajaran')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignUuid('id_kelas')->references('id_kelas')->on('kelas')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignUuid('id_user')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mapel_kelas');
    }
};
