<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('unit')->latest()->get();
        return view('booking.index', compact('bookings'));
    }

    /**
     * Menampilkan form booking untuk unit tertentu berdasarkan ID unit
     */
    public function create($id)
    {
        $unit = Unit::findOrFail($id);
        return view('booking.create', compact('unit'));
    }

    /**
     * Menyimpan data booking dan file upload dari formulir konsumen ke database
     */
    public function store(Request $request)
    {
        // 1. Validasi inputan form dari konsumen
        $request->validate([
            'unit_id'             => 'required|exists:units,id',
            'nama_lengkap'        => 'required|string|max:255',
            'nik'                 => 'required|string|max:20',
            'telepon'             => 'required|string|max:20',
            'ktp_file'            => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'bukti_transfer_file' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        // 2. Tangani upload file KTP
        $ktpPath = null;
        if ($request->hasFile('ktp_file')) {
            $ktpPath = $request->file('ktp_file')->store('ktp_uploads', 'public');
        }

        // 3. Tangani upload file Bukti Transfer
        $buktiTransferPath = null;
        if ($request->hasFile('bukti_transfer_file')) {
            $buktiTransferPath = $request->file('bukti_transfer_file')->store('bukti_transfer_uploads', 'public');
        }

        // 4. Simpan data ke database
        $booking = Booking::create([
            'unit_id'             => $request->unit_id,
            'nama_lengkap'        => $request->nama_lengkap,
            'nik'                 => $request->nik,
            'telepon'             => $request->telepon,
            'ktp_file'            => $ktpPath,
            'bukti_transfer_file' => $buktiTransferPath,
            'status_booking'      => 'Pending',
            'status'              => 'Booking',
        ]);

        // 5. Redirect ke route submissions.search membawa keyword NIK & pesan sukses
        return redirect()->route('submissions.search')->withInput(['keyword' => $booking->nik])->with('success', 'Booking berhasil diajukan! Silakan simpan NIK Anda (' . $booking->nik . ') untuk melakukan pengecekan status.');
    }

    public function edit($id)
    {
        $booking = Booking::findOrFail($id);
        return view('booking.edit', compact('booking'));
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik'          => 'required|string|max:20',
            'telepon'      => 'required|string|max:20',
        ]);

        $booking->update([
            'nama_lengkap' => $request->nama_lengkap,
            'nik'          => $request->nik,
            'telepon'      => $request->telepon,
        ]);

        return redirect()->route('admin.bookings.index')->with('success', 'Data booking berhasil diperbarui!');
    }

    public function updateStatus(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        if ($request->has('status')) {
            $booking->status = $request->status;
            $booking->save();
            return redirect()->back()->with('success', 'Progress pengajuan berhasil diperbarui!');
        }

        if ($request->has('action')) {
            if ($request->action == 'approve') {
                $booking->status_booking = 'Dikonfirmasi';
                if (empty($booking->status)) {
                    $booking->status = 'Booking';
                }
            } elseif ($request->action == 'reject') {
                $booking->status_booking = 'Ditolak';
            }
            $booking->save();
            return redirect()->back()->with('success', 'Status validasi berhasil diperbarui!');
        }

        return redirect()->back();
    }

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        
        // Hapus file fisik KTP jika ada
        if ($booking->ktp_file && Storage::disk('public')->exists($booking->ktp_file)) {
            Storage::disk('public')->delete($booking->ktp_file);
        }

        // Hapus file fisik Bukti Transfer jika ada
        if ($booking->bukti_transfer_file && Storage::disk('public')->exists($booking->bukti_transfer_file)) {
            Storage::disk('public')->delete($booking->bukti_transfer_file);
        }

        $booking->delete();
        return redirect()->back()->with('success', 'Data booking berhasil dihapus.');
    }
}