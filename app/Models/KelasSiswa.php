<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KelasSiswa extends Model
{
    protected $table = 'kelas_siswa';
    protected $primaryKey = 'id_kelas_siswa';
    public $timestamps = false;

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'noinduk', 'noinduk');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }

    public function absen()
    {
        return $this->hasMany(Absen::class, 'id_kelas_siswa');
    }
}