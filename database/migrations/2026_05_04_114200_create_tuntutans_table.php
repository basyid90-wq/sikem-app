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
        Schema::create('tuntutans', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis_tuntutan', ['khairat_kematian', 'elaun_kelas']);
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->foreignId('pemohon_id')->constrained('users')->onDelete('cascade');
            $table->decimal('jumlah_tuntutan', 8, 2);
            $table->enum('status_tuntutan', ['pending', 'lulus_kudd', 'selesai_maipk'])->default('pending');
            $table->string('resit_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tuntutans');
    }
};
