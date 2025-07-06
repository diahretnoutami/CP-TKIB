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
        Schema::table('hasilpb', function (Blueprint $table) {
            $table->unsignedBigInteger('id_kelas_siswa')->after('id_hpb');

            // Foreign key
            $table->foreign('id_kelas_siswa')
                ->references('id_kelas_siswa')
                ->on('kelas_siswa')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hasilpb', function (Blueprint $table) {
            $table->dropForeign(['id_kelas_siswa']);
            $table->dropColumn('id_kelas_siswa');

        });
    }
};