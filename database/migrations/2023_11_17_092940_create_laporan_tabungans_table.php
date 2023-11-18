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
        Schema::create('laporan_tabungan', function (Blueprint $table) {
            $table->id('id_laporan');
            $table->foreignId('id_log_tabungan')->references('id_log_tabungan')->on('log_tabungan')->onDelete('cascade')->onUpdate('cascade');
            $table->string('jumlah_nasabah');
            $table->string('Total_debit');
            $table->string('Total_kredit');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_tabungan');
    }
};
