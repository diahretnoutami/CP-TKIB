<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'guru';

    protected $primaryKey = 'id_guru';

    protected $fillable = [
        'namaguru',
        'id_user',
        'tempatlahir',
        'tanggallahir',
        'jeniskelamin',
        'tanggal_masuk',
        'alamat',
        'nohp'
    ];

    public function getJenisKelaminLabelAttribute()
    {
        return $this->jeniskelamin == 'L' ? 'Laki-laki' : 'Perempuan';
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'id_user');
    }

    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'id_guru');
    }
}