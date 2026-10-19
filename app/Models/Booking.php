<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_id',
        'nama_lengkap',
        'nik',
        'telepon',
        'ktp_file',
        'bukti_transfer_file',
        'status_booking',
        'status', // Kolom untuk progress pengajuan (Booking, Proses, Bank, Akad)
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}