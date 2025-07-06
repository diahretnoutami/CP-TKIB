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
        Schema::create('kelas_siswa', function (Blueprint $table) {
            $table->id('id_kelas_siswa'); // primary key
            $table->unsignedBigInteger('id_kelas');
            $table->string('noinduk');

            // Foreign key
            $table->foreign('id_kelas')->references('id_k')->on('kelas')->onDelete('cascade');
            $table->foreign('noinduk')->references('noinduk')->on('siswa')->onDelete('cascade');

            $table->timestamps(); // opsional, boleh dihapus kalau tidak mau
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas_siswa');
    }
};