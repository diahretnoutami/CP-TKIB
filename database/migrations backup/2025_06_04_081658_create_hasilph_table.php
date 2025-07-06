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
        Schema::create('hasilph', function (Blueprint $table) {
            $table->id('id_hph');
            $table->unsignedBigInteger('id_kelas_siswa');
            $table->unsignedBigInteger('id_ph');
            $table->enum('hasil', ['1', '2', '3', '4']);
            $table->timestamps();

            // Foreign keys
            $table->foreign('id_kelas_siswa')->references('id_kelas_siswa')->on('kelas_siswa')->onDelete('cascade');
            $table->foreign('id_ph')->references('id_ph')->on('penilaian_harian')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasilph');
    }
};