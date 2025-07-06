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
        Schema::create('alur', function (Blueprint $table) {
            $table->id('id_a');
            $table->unsignedBigInteger('id_c'); // foreign key dari tabel cp
            $table->text('alurp');
            $table->timestamps();

            $table->foreign('id_c')->references('id_c')->on('cps')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alur');
    }
};