<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pertemuan extends Model
{
    use HasFactory;

    protected $table = 'pertemuan';
    protected $primaryKey = 'id_p';

    protected $fillable = [
        'id_kelas_siswa',
        'id_guru',
        'id_ortu',
        'tglpengajuan',
        'tglpertemuan',
        'jampertemuan',
        'deskripsi',
        'status',
        'alasan',
    ];

    public function kelasSiswa()
    {
        return $this->belongsTo(KelasSiswa::class, 'id_kelas_siswa');
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru');
    }

    public function ortu()
    {
        return $this->belongsTo(OrangTua::class, 'id_ortu');
    }
}