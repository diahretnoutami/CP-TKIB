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
        Schema::table('hasilpm', function (Blueprint $table) {
            $table->decimal('hasil', 4, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hasilpm', function (Blueprint $table) {
            $table->enum('hasil', ['1', '2', '3', '4'])->change();
        });
    }
};