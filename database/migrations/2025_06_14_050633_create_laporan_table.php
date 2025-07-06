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
        Schema::create('laporan', function (Blueprint $table) {
            $table->id('id_la');
            $table->unsignedBigInteger('id_hpb'); 
            $table->unsignedBigInteger('id_kelas_siswa');
            $table->text('keterangan');
            $table->timestamps();

            $table->foreign('id_kelas_siswa')->references('id_kelas_siswa')->on('kelas_siswa')->onDelete('cascade');
            $table->foreign('id_hpb')->references('id_hpb')->on('hasilpb')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};