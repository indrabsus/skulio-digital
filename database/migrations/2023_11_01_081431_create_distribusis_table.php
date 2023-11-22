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
            $table->bigInteger('volume');
            $table->string('satuan');
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
        Schema::dropIfExists('distribusi');
    }
};
