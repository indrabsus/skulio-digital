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
        Schema::create('bos_realisasi', function (Blueprint $table) {
            $table->uuid('id_realisasi')->primary();
            $table->foreignUuid('id_pengajuan')->references('id_pengajuan')->on('pengajuan')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('volume_realisasi');
            $table->string('bulan_pengajuan_realisasi');
            $table->bigInteger('perkiraan_harga_realisasi');
            $table->enum('status', [1,2,3,4]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bos_realisasis');
    }
};
