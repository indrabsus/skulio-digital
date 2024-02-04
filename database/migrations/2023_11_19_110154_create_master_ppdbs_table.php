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
        Schema::create('master_ppdb', function (Blueprint $table) {
            $table->uuid('id_ppdb')->primary();
            $table->integer('daftar');
            $table->integer('ppdb');
            $table->string('token_telegram');
            $table->string('chat_id');
            $table->integer('tahun');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_ppdb');
    }
};
