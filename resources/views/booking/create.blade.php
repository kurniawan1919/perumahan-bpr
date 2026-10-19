@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4 p-md-5">
                    <h3 class="fw-bold mb-3 text-center">Formulir Booking Unit</h3>
                    <p class="text-muted text-center mb-4">Pilihan Unit: <strong>Nomor {{ $unit->nomor_unit }} ({{ $unit->tipe }})</strong></p>

                    <form action="{{ route('booking.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="unit_id" value="{{ $unit->id }}">

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Lengkap (Sesuai KTP)</label>
                            <input type="text" name="nama_lengkap" class="form-control" required placeholder="Masukkan nama lengkap">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nomor NIK KTP</label>
                            <input type="text" name="nik" class="form-control" required placeholder="Masukkan 16 digit NIK">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nomor Telepon / WhatsApp</label>
                            <input type="text" name="telepon" class="form-control" required placeholder="Contoh: 081234567890">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Upload Foto / Scan KTP</label>
                            <input type="file" name="ktp_file" class="form-control" required accept="image/*">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Upload Bukti Transfer Booking Fee</label>
                            <input type="file" name="bukti_transfer_file" class="form-control" required accept="image/*">
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary fw-bold py-2">Kirim Pengajuan Booking</button>
                            <a href="{{ route('units.index') }}" class="btn btn-outline-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection