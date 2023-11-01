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
        Schema::create('distribusi', function (Blueprint $table) {
            $table->id('id_distribusi');
            $table->foreignId('id_barang')->references('id_barang')->on('barang')->onDelete('cascade')->onUpdate('cascade');
            $table->string('kode_barang');
            $table->string('nama_barang');
            $table->bigInteger('volume');
            $table->string('satuan');
            $table->bigInteger('tahun_masuk');
            $table->enum('sumber', ['bos','yayasan']);
            $table->enum('jenis', ['ab','b']);
            $table->string('id_ruangan');
            $table->string('id_role');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distribusi');
    }
};
