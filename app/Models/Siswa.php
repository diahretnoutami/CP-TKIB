<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';
    protected $primaryKey = 'noinduk';
    public $incrementing = false; // karena noinduk bukan auto-increment
    protected $keyType = 'string';

    protected $fillable = [
        'noinduk',
        'id_ortu',
        'nama',
        'tempatlahir',
        'tgllahir',
        'tinggibadan',
        'beratbadan',
        'lingkarkpl',
        'jeniskelamin'
    ];

    public function orangtua()
    {
        return $this->belongsTo(Orangtua::class, 'id_ortu');
    }

    public function getJenisKelaminLabelAttribute()
    {
        return $this->jeniskelamin == 'L' ? 'Laki-laki' : 'Perempuan';
    }

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'A' => 'Aktif',
            'L' => 'Lulus',
            'N' => 'Non-Aktif',
        };
    }

    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'kelas_siswa', 'noinduk', 'id_kelas');
    }

    public function kelasSiswaAktif()
{
    return $this->hasOne(KelasSiswa::class, 'noinduk', 'noinduk');
}

}