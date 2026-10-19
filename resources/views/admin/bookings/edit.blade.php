@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4 p-md-5">
                    <h3 class="fw-bold mb-3 text-center">Edit Data & Status Booking</h3>
                    <p class="text-muted text-center mb-4">Unit: <strong>Nomor {{ $booking->unit->nomor_unit ?? '-' }}</strong></p>

                    <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap', $booking->nama_lengkap) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">NIK KTP</label>
                            <input type="text" name="nik" class="form-control" value="{{ old('nik', $booking->nik) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nomor Telepon / WhatsApp</label>
                            <input type="text" name="telepon" class="form-control" value="{{ old('telepon', $booking->telepon) }}" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Status Konfirmasi Booking</label>
                            <select name="status_booking" class="form-select" required>
                                <option value="Pending" {{ $booking->status_booking == 'Pending' ? 'selected' : '' }}>Pending (Menunggu)</option>
                                <option value="Dikonfirmasi" {{ $booking->status_booking == 'Dikonfirmasi' ? 'selected' : '' }}>Dikonfirmasi (Setuju & Kunci Unit)</option>
                                <option value="Ditolak" {{ $booking->status_booking == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                            <div class="form-text text-muted">Mengubah status menjadi "Dikonfirmasi" akan otomatis mengunci status unit.</div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary fw-bold py-2">Simpan Perubahan</button>
                            <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection