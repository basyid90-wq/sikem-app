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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('kariah_id')->after('password')->nullable()->constrained('kariahs')->onDelete('set null');
            $table->foreignId('mualaf_id')->after('kariah_id')->nullable()->constrained('mualafs')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['kariah_id']);
            $table->dropForeign(['mualaf_id']);
            $table->dropColumn(['kariah_id', 'mualaf_id']);
        });
    }
};
