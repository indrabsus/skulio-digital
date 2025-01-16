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
        Schema::create('pengajuan', function (Blueprint $table) {
            $table->uuid('id_pengajuan')->primary();
            $table->string('nama_barang');
            $table->bigInteger('volume');
            $table->string('satuan');
            $table->string('bulan_pengajuan');
            $table->bigInteger('tahun_arkas');
            $table->bigInteger('perkiraan_harga');
            $table->enum('jenis', ['ab','b']);
            $table->foreignUuid('id_role')->references('id_role')->on('roles')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan');
    }
};
