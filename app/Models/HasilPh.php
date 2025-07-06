<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilPh extends Model
{

    protected $table = 'hasilph'; // <--- Nama tabel sebenarnya di database kamu

    protected $primaryKey = 'id_hph';

    protected $fillable = [
        'id_kelas_siswa',
        'id_ph',
        'hasil',
        'dokumentasi'
    ];
    public function ph()
    {
        return $this->belongsTo(PenilaianHarian::class, 'id_ph');
    }

    public function kelasSiswa()
    {
        return $this->belongsTo(KelasSiswa::class, 'id_kelas_siswa');
    }

    public function penilaianHarian()
    {
        return $this->belongsTo(PenilaianHarian::class, 'id_ph');
    }
}