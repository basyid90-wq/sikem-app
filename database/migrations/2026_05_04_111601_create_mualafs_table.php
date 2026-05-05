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
        Schema::create('mualafs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_penuh');
            $table->string('no_ic')->unique();
            $table->string('no_kad_mualaf')->unique()->nullable();
            $table->date('tarikh_syahadah')->nullable();
            $table->foreignId('kariah_id')->nullable()->constrained('kariahs')->onDelete('set null');
            $table->boolean('status_khairat')->default(false);
            $table->text('alamat_terkini')->nullable();
            $table->string('waris_islam_nama')->nullable();
            $table->string('waris_islam_tel')->nullable();
            $table->string('waris_non_nama')->nullable();
            $table->string('waris_non_tel')->nullable();
            $table->string('sijil_islam_path')->nullable();
            $table->string('kad_mualaf_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mualafs');
    }
};
