<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cp extends Model
{
    use HasFactory;

    protected $table = 'cps';

    protected $primaryKey = 'id_c';

    protected $fillable = [
        'materi',
        'capaian',
        'tujuan',
    ];

    public function alur()
    {
        return $this->hasMany(Alur::class, 'id_c', 'id_c');
    }

    public function penilaianHarian()
    {
        return $this->hasMany(PenilaianHarian::class, 'id_c', 'id_c');
    }

    // Di App\Models\Cps.php
    public function deskripsi()
    {
        return $this->hasMany(DesLaporan::class, 'id_c', 'id_c');
    }
}