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
        Schema::create('refleksi', function (Blueprint $table) {
            $table->uuid('id_refleksi')->primary();
            $table->foreignUuid('id_kombel')->references('id_kombel')->on('kombel')->onUpdate('cascade')->onDelete('cascade');
            $table->text('pertanyaan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refleksis');
    }
};
