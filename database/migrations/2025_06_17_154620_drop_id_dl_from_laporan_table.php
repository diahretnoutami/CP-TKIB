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
            $table->dropForeign(['id_dl']);
            $table->dropColumn('id_dl');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporan', function (Blueprint $table) {
             $table->unsignedBigInteger('id_dl')->nullable();
            $table->foreign('id_dl')->references('id_dl')->on('des_laporan');
        });
    }
};