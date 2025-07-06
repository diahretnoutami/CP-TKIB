<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';
    protected $primaryKey = 'id_k';
    public $timestamps = true;

    protected $fillable = [
        'id_guru',
        'id_ta',
        'nama_kelas',
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru', 'id_guru');
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'id_ta', 'id_ta');
    }

    public function siswa()
    {
        return $this->belongsToMany(Siswa::class, 'kelas_siswa', 'id_kelas', 'noinduk');
    }


    //public function kelasSiswa()
    //{
    // return $this->hasMany(KelasSiswa::class, 'id_kelas', 'id_k');
    //}

}