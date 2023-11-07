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
        Schema::create('data_peminjam', function (Blueprint $table) {
            $table->id("id_peminjam");
            $table->foreignId('id_siswa')->references('id_siswa')->on('data_siswa')->onUpdate('cascade')->onDelete('cascade');
            $table->string("nama_buku");
            $table->dateTime("tanggal_pinjam");
            $table->enum('kembali',['y','n']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_peminjam');
    }
};
