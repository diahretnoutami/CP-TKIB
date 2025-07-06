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
        Schema::table('cps', function (Blueprint $table) {
            $table->renameColumn('id', 'id_c');  // Mengubah kolom 'id' menjadi 'id_c'
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cps', function (Blueprint $table) {
            $table->renameColumn('id_c', 'id');
        });
    }
};