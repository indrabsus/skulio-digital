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
        Schema::create('masukan', function (Blueprint $table) {
            $table->uuid('id_masukan')->primary();
            $table->foreignUuid(column: 'id_user')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->text('masukan');
            $table->string('kategori');
            $table->string('gambar')->nullable();
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('masukans');
    }
};
