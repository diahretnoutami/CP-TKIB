<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hasilpb extends Model
{
    protected $table = 'hasilpb';
    protected $primaryKey = 'id_hpb';

    protected $fillable = [
        'id_kelas_siswa',
        'id_a',
        'bulan',
        'hasil'
    ];

    public function alur()
    {
        return $this->belongsTo(Alur::class, 'id_a');
    }

    public function cp()
    {
        return $this->alur ? $this->alur->cp() : null;
    }

    public function penilaianHarian()
    {
        return $this->belongsTo(\App\Models\PenilaianHarian::class, 'id_ph', 'id_ph');
    }
}