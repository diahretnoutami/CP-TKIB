<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DesLaporan extends Model
{
    protected $table = 'des_laporan';

    protected $primaryKey = 'id_dl';

    protected $fillable = [
        'id_c',         // FK ke tabel cps
        'nilaiakhir',   // Decimal nilai akhir (1 - 4)
        'keterangan',   // Kalimat deskriptif default
    ];

    public function cp()
    {
        return $this->belongsTo(cp::class, 'id_c', 'id_c');
    }
}