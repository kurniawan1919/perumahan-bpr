<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Unit;

class UnitSeeder extends Seeder
{
    public function run()
    {
        // Masukkan beberapa contoh data unit rumah
        Unit::create([
            'nomor_unit' => 'A-01',
            'tipe' => 'Tipe 36/72',
            'luas_tanah' => 72,
            'luas_bangunan' => 36,
            'harga' => 350000000,
            'status' => 'Ready',
            'spesifikasi' => 'Pondasi batu kali, dinding bata merah diplester acian, lantai granit 60x60, atap rangka baja ringan, genteng beton.',
            'foto_url' => null,
            'denah_url' => null,
        ]);

        Unit::create([
            'nomor_unit' => 'A-02',
            'tipe' => 'Tipe 36/72',
            'luas_tanah' => 72,
            'luas_bangunan' => 36,
            'harga' => 350000000,
            'status' => 'Booking',
            'spesifikasi' => 'Pondasi batu kali, dinding bata merah diplester acian, lantai granit 60x60, atap rangka baja ringan, genteng beton.',
            'foto_url' => null,
            'denah_url' => null,
        ]);

        Unit::create([
            'nomor_unit' => 'B-05',
            'tipe' => 'Tipe 45/90',
            'luas_tanah' => 90,
            'luas_bangunan' => 45,
            'harga' => 475000000,
            'status' => 'Ready',
            'spesifikasi' => 'Pondasi cakar ayam, dinding bata merah, lantai granit premium, plafon gypsum tinggi 4 meter, carport luas.',
            'foto_url' => null,
            'denah_url' => null,
        ]);
    }
}