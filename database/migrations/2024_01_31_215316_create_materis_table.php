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
        Schema::create('materi', function (Blueprint $table) {
            $table->uuid('id_materi')->unique();
            $table->foreignUuid('id_mapelkelas')->references('id_mapelkelas')->on('mapel_kelas')->onUpdate('cascade')->onDelete('cascade');
            $table->string('materi');
            $table->bigInteger('semester');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materis');
    }
};
