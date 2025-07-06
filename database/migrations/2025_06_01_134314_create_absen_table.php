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
        Schema::create('absen', function (Blueprint $table) {
            $table->id('id_ab');
            $table->unsignedBigInteger('id_kelas_siswa');
            $table->date('tanggal');
            $table->enum('status', ['H', 'A', 'S', 'I']); // Hadir, Alfa, Sakit, Izin
            $table->timestamps();

            $table->foreign('id_kelas_siswa')->references('id_kelas_siswa')->on('kelas_siswa')->onDelete('cascade');
            $table->unique(['id_kelas_siswa', 'tanggal']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absen');
    }
};