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
        Schema::create('des_laporan', function (Blueprint $table) {
            $table->id('id_dl');
            $table->unsignedBigInteger('id_c');
            $table->foreign('id_c')->references('id_c')->on('cps')->onDelete('cascade');

            // Nilai akhir bulat (1–4)
            $table->tinyInteger('nilaiakhir');
            $table->text('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('des_laporan');
    }
};