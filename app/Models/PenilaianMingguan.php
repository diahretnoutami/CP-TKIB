<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PenilaianMingguan extends Model
{

    use HasFactory;
    protected $table = 'penilaian_mingguan';
    protected $primaryKey = 'id_pm';
    public $timestamps = false;

    protected $fillable = ['id_a', 'minggu'];


    public function alur()
    {
        return $this->belongsTo(Alur::class, 'id_a', 'id_a');
    }
}