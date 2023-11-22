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
        Schema::create('log_ppdb', function (Blueprint $table) {
            $table->id('id_log');
            $table->foreignId('id_siswa')->references('id_siswa')->on('siswa_ppdb')->onUpdate('cascade')->onDelete('cascade');
            $table->string('nominal');
            $table->enum('jenis', ['d','p'] );
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_ppdb');
    }
};
