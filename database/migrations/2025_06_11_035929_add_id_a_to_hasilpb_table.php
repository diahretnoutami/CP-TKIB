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
            $table->unsignedBigInteger('id_a')->after('id_kelas_siswa');

            // Tambahkan foreign key constraint ke tabel alur
            $table->foreign('id_a')->references('id_a')->on('alur')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hasilpb', function (Blueprint $table) {
            $table->dropForeign(['id_a']);
            $table->dropColumn('id_a');
        });
    }
};