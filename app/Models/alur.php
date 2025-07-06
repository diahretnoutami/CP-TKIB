<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class alur extends Model
{
    protected $table = 'alur';
    protected $primaryKey = 'id_a';
    protected $fillable = ['id_c', 'alurp', 'nomor_alur', 'semester'];

    public function capaian()
    {
        return $this->belongsTo(Cp::class, 'id_c', 'id_c');
    }

    public function PenilaianHarian()
    {
        return $this->hasMany(PenilaianHarian::class, 'id_a');
    }

    public function PenilaianMingguan()
    {
        return $this->hasMany(PenilaianMingguan::class, 'id_a');
    }
}