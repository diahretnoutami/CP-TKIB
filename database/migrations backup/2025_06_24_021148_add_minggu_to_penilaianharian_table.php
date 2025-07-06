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
        Schema::table('penilaian_harian', function (Blueprint $table) {
            $table->unsignedTinyInteger('minggu')->after('tanggal')->nullable();
            $table->unsignedBigInteger('id_ta')->after('id_t')->nullable();

            $table->foreign('id_ta')->references('id_ta')->on('tahun_ajaran')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penilaian_harian', function (Blueprint $table) {
            $table->dropForeign(['id_ta']);
            $table->dropColumn(['id_ta', 'minggu']);
        });
    }
};