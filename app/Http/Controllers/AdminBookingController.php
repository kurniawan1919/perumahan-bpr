<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Unit;
use Illuminate\Support\Facades\Storage;

class AdminBookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('unit')->latest()->get();
        return view('admin.bookings.index', compact('bookings'));
    }

    public function updateStatus(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $unit = Unit::findOrFail($booking->unit_id);

        // 1. Tangani jika tombol SIMPAN pada dropdown progress pengajuan diklik
        if ($request->has('status') && !$request->has('action')) {
            $booking->status = $request->status;
            $booking->save();

            return back()->with('success', 'Progress pengajuan konsumen berhasil diperbarui!');
        }

        // 2. Tangani jika tombol SETUJUI atau TOLAK diklik
        if ($request->filled('action')) {
            $action = $request->input('action');

            if ($action === 'approve') {
                $sudahDipesan = Booking::where('unit_id', $unit->id)
                                        ->where('status_booking', 'Dikonfirmasi')
                                        ->where('id', '!=', $booking->id)
                                        ->exists();

                if ($sudahDipesan) {
                    return back()->with('error', 'Gagal! Unit ini sudah dikonfirmasi dan dimiliki oleh konsumen lain.');
                }

                $booking->status_booking = 'Dikonfirmasi';
                
                if (empty($booking->status)) {
                    $booking->status = 'Booking';
                }

                $booking->save();

                $unit->status = 'Booking';
                $unit->save();

                Booking::where('unit_id', $unit->id)
                        ->where('id', '!=', $booking->id)
                        ->where('status_booking', 'Pending')
                        ->update(['status_booking' => 'Ditolak']);

                return back()->with('success', 'Booking berhasil disetujui!');
            } 
            elseif ($action === 'reject') {
                $booking->status_booking = 'Ditolak';
                $booking->save();

                $masihAdaKonfirmasiLain = Booking::where('unit_id', $unit->id)
                                                ->where('status_booking', 'Dikonfirmasi')
                                                ->exists();

                if (!$masihAdaKonfirmasiLain) {
                    $unit->status = 'Ready';
                    $unit->save();
                }

                return back()->with('error', 'Booking telah ditolak.');
            }
        }

        return back()->with('error', 'Permintaan tidak valid.');
    }

    public function edit($id)
    {
        $booking = Booking::with('unit')->findOrFail($id);
        return view('admin.bookings.edit', compact('booking'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|string|max:20',
            'telepon' => 'required|string|max:15',
            'status_booking' => 'required|in:Pending,Dikonfirmasi,Ditolak',
            'status' => 'nullable|string',
        ]);

        $booking = Booking::findOrFail($id);
        $oldStatus = $booking->status_booking;
        $newStatus = $request->status_booking;
        $unit = Unit::findOrFail($booking->unit_id);

        if ($newStatus === 'Dikonfirmasi' && $oldStatus !== 'Dikonfirmasi') {
            $sudahDipesan = Booking::where('unit_id', $unit->id)
                                    ->where('status_booking', 'Dikonfirmasi')
                                    ->where('id', '!=', $booking->id)
                                    ->exists();

            if ($sudahDipesan) {
                return back()->with('error', 'Gagal! Unit ini sudah dikonfirmasi untuk konsumen lain.');
            }

            $unit->status = 'Booking';
            $unit->save();
        } 
        elseif ($oldStatus === 'Dikonfirmasi' && $newStatus !== 'Dikonfirmasi') {
            $masihAdaKonfirmasiLain = Booking::where('unit_id', $unit->id)
                                            ->where('status_booking', 'Dikonfirmasi')
                                            ->where('id', '!=', $booking->id)
                                            ->exists();

            if (!$masihAdaKonfirmasiLain) {
                $unit->status = 'Ready';
                $unit->save();
            }
        }

        $booking->nama_lengkap = $request->nama_lengkap;
        $booking->nik = $request->nik;
        $booking->telepon = $request->telepon;
        $booking->status_booking = $newStatus;
        
        if ($request->has('status')) {
            $booking->status = $request->status;
        }

        $booking->save();

        return redirect()->route('admin.bookings.index')->with('success', 'Data booking dan status berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $unit = Unit::findOrFail($booking->unit_id);

        if ($booking->status_booking === 'Dikonfirmasi') {
            $unit->status = 'Ready';
            $unit->save();
        }

        if ($booking->ktp_file && Storage::disk('public')->exists($booking->ktp_file)) {
            Storage::disk('public')->delete($booking->ktp_file);
        }
        if ($booking->bukti_transfer_file && Storage::disk('public')->exists($booking->bukti_transfer_file)) {
            Storage::disk('public')->delete($booking->bukti_transfer_file);
        }

        $booking->delete();

        return back()->with('success', 'Data booking berhasil dihapus.');
    }
}