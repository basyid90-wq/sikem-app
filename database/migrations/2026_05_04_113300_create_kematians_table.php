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
        Schema::create('kematians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mualaf_id')->constrained('mualafs')->onDelete('cascade');
            $table->foreignId('pelapor_id')->nullable()->constrained('users')->onDelete('set null');
            $table->date('tarikh_mati');
            $table->string('lokasi_mati');
            $table->boolean('status_tuntutan_non')->default(false);
            $table->enum('status_kes', ['baru', 'dalam_proses', 'selesai'])->default('baru');
            $table->text('nota_log')->nullable();
            $table->string('polis_report_path')->nullable();
            $table->string('surat_wakil_path')->nullable();
            $table->boolean('kariah_dimaklumkan')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kematians');
    }
};
