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
            $table->id('id_barang');
            $table->string('kode_barang');
            $table->string('nama_barang');
            $table->bigInteger('volume');
            $table->string('satuan');
            $table->bigInteger('tahun_masuk');
            $table->enum('sumber', ['bos','yayasan']);
            $table->enum('jenis', ['ab','b']);
            $table->foreignId('id_ruangan')->references('id_ruangan')->on('ruangan')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('id_role')->references('id_role')->on('roles')->onDelete('cascade')->onUpdate('cascade');

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
