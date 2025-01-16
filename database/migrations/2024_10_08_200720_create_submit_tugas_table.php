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
        Schema::create('submit_tugas', function (Blueprint $table) {
            $table->uuid('id_submit')->primary();
            $table->foreignUuid(column: 'id_tugas')->references('id_tugas')->on('tugas')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignUuid(column: 'id_user')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->text('jawaban')->nullable();
            $table->bigInteger('nilai')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submit_tugas');
    }
};
