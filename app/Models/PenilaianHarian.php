<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenilaianHarian extends Model
{
    protected $table = 'penilaian_harian';
    protected $primaryKey = 'id_ph';

    protected $fillable = ['id_a', 'id_t', 'id_ta', 'id_c', 'tanggal', 'kegiatan', 'minggu'];


    public function alur()
    {
        return $this->belongsTo(Alur::class, 'id_a', 'id_a');
    }

    public function tema()
    {
        return $this->belongsTo(Tema::class, 'id_t', 'id_t');
    }

    public function cp()
    {
        return $this->belongsTo(cp::class, 'id_c', 'id_c');
    }

    public function tahunajaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'id_ta', 'id_ta');
    }

    public function penilaianHarian()
    {
        return $this->belongsTo(\App\Models\PenilaianHarian::class, 'id_ph');
    }
}