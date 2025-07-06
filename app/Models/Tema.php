<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tema extends Model
{
    protected $table = 'tema';
    protected $primaryKey = 'id_t';
    protected $fillable = ['id_c', 'tema'];

    public function penilaianHarian()
    {
        return $this->hasMany(PenilaianHarian::class, 'id_t');
    }
}