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
        Schema::create('log_luar_spp', function (Blueprint $table) {
            $table->uuid('id_logluar')->primary();
            $table->string('keterangan');
            $table->enum('status', ['m','k']);
            $table->enum('via',['trf','cash']);
            $table->bigInteger('nominal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_luar_spp');
    }
};
