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
            $table->float('nilaiakhir')->after('id_kelas_siswa');
            $table->unsignedBigInteger('id_dl')->after('nilaiakhir');
            $table->unsignedBigInteger('id_hpm')->nullable()->after('id_dl');
            $table->unsignedBigInteger('id_c')->after('id_kelas_siswa');
            $table->foreign('id_c')->references('id_c')->on('cps')->onDelete('cascade');

            // Foreign key
            $table->foreign('id_dl')->references('id_dl')->on('des_laporan')->onDelete('cascade');
            $table->foreign('id_hpm')->references('id_hpm')->on('hasilpm')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporan', function (Blueprint $table) {
            $table->dropForeign(['id_dl']);
            $table->dropForeign(['id_hpm']);
            $table->dropForeign(['id_c']);
            $table->dropColumn('id_c');

            $table->dropColumn(['nilaiakhir', 'id_dl', 'id_hpm']);
        });
    }
};