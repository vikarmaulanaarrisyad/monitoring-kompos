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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('nama_aplikasi');
            $table->string('singkatan_aplikasi');
            $table->text('deskripsi_aplikasi');
            $table->string('owner1');
            $table->string('owner2');
            $table->string('logo')->default('logo.png');
            $table->string('favicon')->default('favicon.png');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
