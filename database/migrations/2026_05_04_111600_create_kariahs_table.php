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
        Schema::create('kariahs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kariah');
            $table->string('zon_daerah');
            $table->text('alamat')->nullable();
            $table->string('nama_ajk')->nullable();
            $table->string('no_telefon')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kariahs');
    }
};
