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
            $table->uuid('id_distribusi')->primary();
            $table->foreignUuid('id_realisasi')->references('id_realisasi')->on('bos_realisasi')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('volume_distribusi');
            $table->foreignUuid('id_role')->references('id_role')->on('roles')->onDelete('cascade')->onUpdate('cascade');
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
