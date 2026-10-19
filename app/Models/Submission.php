<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'tahapan_sekarang',
        'keterangan_admin',
    ];

    // Relasi kembali ke tabel bookings
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }
}