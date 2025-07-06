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
        Schema::create('siswa', function (Blueprint $table) {
            $table->string('noinduk')->primary();
            $table->unsignedBigInteger('id_ortu'); // FOREIGN KEY
            $table->string('nama');
            $table->string('tempatlahir');
            $table->date('tgllahir');
            $table->integer('tinggibadan')->nullable();
            $table->integer('beratbadan')->nullable();
            $table->enum('jeniskelamin', ['L', 'P']);
            $table->timestamps();

            $table->foreign('id_ortu')->references('id_ortu')->on('orangtua')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};