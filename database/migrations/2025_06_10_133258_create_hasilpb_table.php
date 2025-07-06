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
        Schema::create('hasilpb', function (Blueprint $table) {
            $table->id('id_hpb');
            $table->unsignedBigInteger('id_hpm'); 
            $table->tinyInteger('bulan'); 
            $table->decimal('hasil', 5, 2); 
            $table->string('dokumentasi')->nullable();
            $table->timestamps();

            $table->foreign('id_hpm')->references('id_hpm')->on('hasilpm')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasilpb');
    }
};