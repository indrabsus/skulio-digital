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
        Schema::create('jurusan_ppdb', function (Blueprint $table) {
            $table->uuid('id_jurusan');
            $table->string('nama_jurusan');
            $table->foreignUuid('id_ppdb')->references('id_ppdb')->on('master_ppdb')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurusan_ppdb');
    }
};
