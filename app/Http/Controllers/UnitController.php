<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit; // Memanggil Model Unit yang sudah kita buat

class UnitController extends Controller
{
    public function index()
    {
        // Mengambil seluruh data unit dari database
        $units = Unit::all();

        // Mengirim data unit ke file view 'units.index'
        return view('units.index', compact('units'));
    }
}