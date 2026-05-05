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
        Schema::create('kehadiran_apim', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelas_id')->constrained('kelas_apim')->onDelete('cascade');
            $table->foreignId('mualaf_id')->constrained('mualafs')->onDelete('cascade');
            $table->boolean('status_hadir')->default(false);
            $table->datetime('waktu_rekod')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kehadiran_apim');
    }
};
