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
        Schema::table('hasilph', function (Blueprint $table) {
             $table->string('dokumentasi')->nullable()->after('hasil');
        });

        Schema::table('hasilpm', function (Blueprint $table) {
            $table->dropColumn('dokumentasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hasilph', function (Blueprint $table) {
            $table->dropColumn('dokumentasi');
        });

         Schema::table('hasilpm', function (Blueprint $table) {
            $table->string('dokumentasi')->nullable();
        });
    }
};