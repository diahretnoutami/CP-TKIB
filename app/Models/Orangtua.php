<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable; 
use Laravel\Sanctum\HasApiTokens;


class Orangtua extends Model
{
    use HasApiTokens, HasFactory;

    protected $table = 'orangtua';
    protected $primaryKey = 'id_ortu';

    protected $fillable = [
        'namaortu',
        'pekerjaan',
        'nohp',
        'alamat',
    ];

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'id_ortu', 'id_ortu');
    }
}