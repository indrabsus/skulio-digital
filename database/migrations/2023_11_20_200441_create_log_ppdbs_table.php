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
            $table->uuid('id_log');
            $table->foreignUuid('id_siswa')->references('id_siswa')->on('siswa_ppdb')->onUpdate('cascade')->onDelete('cascade');
            $table->string('nominal');
            $table->string('no_invoice');
            $table->enum('jenis', ['d','p','l'] );
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
