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
        Schema::create('log_spp', function (Blueprint $table) {
            $table->uuid('id_logspp')->primary();
            $table->foreignUuid('id_siswa')->references('id_siswa')->on('data_siswa')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('nominal');
            $table->bigInteger('bulan');
            $table->bigInteger('kelas');
            $table->string('keterangan');
            $table->enum('status',['lunas','cicil']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_spps');
    }
};
