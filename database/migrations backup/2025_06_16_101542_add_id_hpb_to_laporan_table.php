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
        Schema::table('laporan', function (Blueprint $table) {
            $table->unsignedBigInteger('id_hpb')->nullable()->after('id_dl');
            $table->foreign('id_hpb')->references('id_hpb')->on('hasilpb')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporan', function (Blueprint $table) {
            $table->dropForeign(['id_hpb']);
            $table->dropColumn('id_hpb');
        });
    }
};