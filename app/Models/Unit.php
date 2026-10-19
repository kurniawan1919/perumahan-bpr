<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $table = 'units';

    // PASTIKAN 'foto' ADA DI DALAM DAFTAR INI
    protected $fillable = [
        'nomor_unit',
        'tipe',
        'luas_tanah',
        'luas_bangunan',
        'harga',
        'status',
        'spesifikasi',
        'foto', 
    ];

    public function photos()
    {
        return $this->hasMany(UnitPhoto::class);
    }
}
