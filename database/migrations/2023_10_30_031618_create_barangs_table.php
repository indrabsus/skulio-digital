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
        Schema::create('barang', function (Blueprint $table) {
            $table->uuid('id_barang')->primary();
            $table->string('nama_barang');
            $table->bigInteger('volume');
            $table->string('satuan');
            $table->bigInteger('tahun_masuk');
            $table->enum('sumber', ['bos','yayasan']);
            $table->bigInteger('tahun_arkas');
            $table->enum('jenis', ['ab','b']);
            $table->foreignUuid('id_ruangan')->references('id_ruangan')->on('ruangan')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignUuid('id_role')->references('id_role')->on('roles')->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
