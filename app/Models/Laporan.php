<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporan';
    protected $primaryKey = 'id_la';

    protected $fillable = [
        'id_hph',
        'id_hpb',
        'id_kelas_siswa',
        'id_c',
        'nilaiakhir',
        'keterangan',
        'dokumentasi',
    ];

    public function deskripsi()
    {
        return $this->belongsTo(DesLaporan::class, 'id_dl', 'id_dl');
    }

    public function hasilph()
    {
        return $this->belongsTo(HasilPh::class, 'id_hph', 'id_hph');
    }

    public function hasilpb()
    {
        return $this->belongsTo(Hasilpb::class, 'id_hpb', 'id_hpb');
    }

    public function kelasSiswa()
    {
        return $this->belongsTo(KelasSiswa::class, 'id_kelas_siswa', 'id_kelas_siswa');
    }

    public function cp()
    {
        return $this->belongsTo(Cp::class, 'id_c', 'id_c');
    }

    public function alur()
    {
        return $this->belongsTo(\App\Models\Alur::class, 'id_a', 'id_a');
    }

    public function penilaianHarian()
    {
        return $this->belongsTo(\App\Models\PenilaianHarian::class, 'id_ph', 'id_ph');
    }

    public function hasilpm()
{
    return $this->belongsTo(Hasilpm::class, 'id_hpm');
}
}