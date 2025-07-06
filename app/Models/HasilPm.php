<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilPm extends Model
{
    use HasFactory;

    protected $table = 'hasilpm';
    protected $primaryKey = 'id_hpm';

    protected $fillable = [
        'id_kelas_siswa',
        'id_a',
        'minggu',
        'hasil',
        'dokumentasi',
    ];

    // Relasi ke kelas_siswa
    public function kelasSiswa()
    {
        return $this->belongsTo(KelasSiswa::class, 'id_kelas_siswa');
    }

    // Relasi ke alur
    public function alur()
    {
        return $this->belongsTo(Alur::class, 'id_a');
    }

    public function cp()
    {
        return $this->hasOneThrough(
            Cp::class,
            Alur::class,
            'id_a',     // foreign key di alur
            'id_c',     // foreign key di cp
            'id_a',     // local key di hasilpm
            'id_c'      // local key di alur
        );
    }

    public function penilaianHarian()
    {
        return $this->belongsTo(\App\Models\PenilaianHarian::class, 'id_ph', 'id_ph');
    }
}