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
        Schema::table('mualafs', function (Blueprint $table) {
            $table->string('nama_asal')->nullable();
            $table->string('jantina')->nullable();
            $table->string('bangsa_asal')->nullable();
            $table->date('tarikh_lahir')->nullable();
            $table->string('no_telefon')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('status_perkahwinan')->nullable();
            $table->integer('bil_anak')->default(0)->nullable();
            $table->text('tempat_syahadah')->nullable();
            $table->boolean('status_kematian')->default(false)->nullable();

            $table->string('no_kad_mualaf')->nullable()->change();
            $table->string('waris_islam_nama')->nullable()->change();
            $table->string('waris_islam_tel')->nullable()->change();
            $table->string('waris_non_nama')->nullable()->change();
            $table->string('waris_non_tel')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mualafs', function (Blueprint $table) {
            $table->dropColumn([
                'nama_asal',
                'jantina',
                'bangsa_asal',
                'tarikh_lahir',
                'no_telefon',
                'pekerjaan',
                'status_perkahwinan',
                'bil_anak',
                'tempat_syahadah',
                'status_kematian',
            ]);
        });
    }
};
