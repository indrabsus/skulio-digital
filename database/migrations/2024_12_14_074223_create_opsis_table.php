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
        Schema::create('opsi', function (Blueprint $table) {
            $table->uuid('id_opsi')->primary();
            $table->foreignUuid(column: 'id_soal')->references('id_soal')->on('soal')->onUpdate('cascade')->onDelete('cascade');
            $table->string('opsi');
            $table->string('opsi_gambar')->nullable();
            $table->boolean('benar')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opsis');
    }
};
