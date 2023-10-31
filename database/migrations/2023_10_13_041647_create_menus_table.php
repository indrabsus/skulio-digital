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
        Schema::create('menu', function (Blueprint $table) {
            $table->id('id_menu');
            $table->bigInteger('sort');
            $table->string('path');
            $table->string('class');
            $table->string('name');
            $table->foreignId('parent_menu')->nullable()->references('id_parent')->on('parent_menu')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('akses_role')->nullable()->references('id_role')->on('roles')->onDelete('cascade')->onUpdate('cascade');
            $table->string('nama_menu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu');
    }
};
