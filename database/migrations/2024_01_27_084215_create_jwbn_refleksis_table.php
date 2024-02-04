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
        Schema::create('jwbn_refleksi', function (Blueprint $table) {
            $table->uuid('id_jawaban');
            $table->foreignUuid('id_refleksi')->references('id_refleksi')->on('refleksi')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignUuid('id_user')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->text('jawaban');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jwbn_refleksis');
    }
};
