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
        Schema::create('hasilpm', function (Blueprint $table) {
            $table->id('id_hpm');
            $table->unsignedBigInteger('id_kelas_siswa');
            $table->unsignedBigInteger('id_a');
            $table->tinyInteger('minggu'); // 1-16
            $table->enum('hasil', [1, 2, 3, 4]);
            $table->string('dokumentasi')->nullable(); // path gambar
            $table->timestamps();

            // Foreign keys
            $table->foreign('id_kelas_siswa')->references('id_kelas_siswa')->on('kelas_siswa')->onDelete('cascade');
            $table->foreign('id_a')->references('id_a')->on('alur')->onDelete('cascade');

            // Supaya tiap siswa hanya 1 nilai per alur per minggu
            $table->unique(['id_kelas_siswa', 'id_a', 'minggu']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasilpm');
    }
};