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
        Schema::create('kombel', function (Blueprint $table) {
            $table->uuid('id_kombel')->primary();
            $table->bigInteger('pertemuan');
            $table->string('tema');
            $table->string('narasumber');
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kombels');
    }
};
