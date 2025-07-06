<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $table = 'semester';

    protected $primaryKey = 'id';

    protected $fillable = ['semester', 'aktif'];

    
    public static function getAktif()
    {
        return self::where('aktif', true)->first()->semester ?? 1; // default semester 1
    }
}