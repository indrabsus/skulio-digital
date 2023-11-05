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
        Schema::create('setingan', function (Blueprint $table) {
            $table->id('id_setingan');
            $table->string('nama_instansi');
            $table->string('default_password');
            $table->float('long');
            $table->float('lat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setingan');
    }
};
