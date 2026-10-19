<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class SubmissionController extends Controller
{
    public function index()
    {
        // Mengarahkan ke resources/views/submissions/check.blade.php
        return view('submissions.check');
    }

    public function search(Request $request)
    {
        $request->validate([
            'keyword' => 'required|string',
        ]);

        $keyword = trim($request->keyword);

        // Cari berdasarkan NIK atau Nomor Telepon
        $booking = Booking::with('unit')
            ->where('nik', $keyword)
            ->orWhere('telepon', $keyword)
            ->latest()
            ->first();

        if (!$booking) {
            return back()->with('error', 'Data pengajuan tidak ditemukan. Pastikan NIK atau Nomor Telepon yang Anda masukkan benar.');
        }

        // Mengarahkan kembali ke submissions.check dengan membawa data booking
        return view('submissions.check', compact('booking'));
    }
}