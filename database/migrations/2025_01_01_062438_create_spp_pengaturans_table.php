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
        Schema::create('spp_pengaturan', function (Blueprint $table) {
            $table->uuid('id_spp_pengaturan')->primary();
            $table->string('token_telegram');
            $table->string('chat_id');
            $table->bigInteger('kas_awal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spp_pengaturan');
    }
};
