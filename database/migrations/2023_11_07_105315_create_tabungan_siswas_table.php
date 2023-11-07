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
        Schema::create('tabungan_siswa', function (Blueprint $table) {
            $table->id('id_tabungan');
            $table->foreignId('id_siswa')->references('id_siswa')->on('data_siswa')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('jumlah_saldo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tabungan_siswa');
    }
};
