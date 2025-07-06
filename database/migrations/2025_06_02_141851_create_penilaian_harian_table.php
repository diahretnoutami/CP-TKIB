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
        Schema::create('penilaian_harian', function (Blueprint $table) {
            $table->id('id_ph');
            $table->unsignedBigInteger('id_a');
            $table->unsignedBigInteger('id_t');
            $table->date('tanggal');
            $table->text('kegiatan');

            $table->timestamps();

            $table->foreign('id_a')->references('id_a')->on('alur')->onDelete('cascade');
            $table->foreign('id_t')->references('id_t')->on('tema')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_harian');
    }
};