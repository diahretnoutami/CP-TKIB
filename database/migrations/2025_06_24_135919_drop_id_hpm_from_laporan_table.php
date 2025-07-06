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
            $table->dropForeign(['id_hpm']);
            $table->dropColumn('id_hpm');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporan', function (Blueprint $table) {
            $table->unsignedBigInteger('id_hpm')->nullable();
        $table->foreign('id_hpm')->references('id_hpm')->on('hasilpm')->onDelete('cascade');
        });
    }
};