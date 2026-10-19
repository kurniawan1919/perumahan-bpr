@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4">Kelola Data Booking & Validasi Pembayaran</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Pemesan</th>
                    <th>NIK</th>
                    <th>Telepon</th>
                    <th>Unit</th>
                    <th>KTP</th>
                    <th>Bukti Transfer</th>
                    <th>Validasi Pembayaran</th>
                    <th style="min-width: 230px;">Progress Pengajuan</th>
                    <th>Aksi Admin</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($bookings) && count($bookings) > 0)
                    @foreach($bookings as $index => $b)
                    @php
                        $currentStatus = strtolower(trim($b->status ?? ''));
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="fw-bold">{{ $b->nama_lengkap }}</td>
                        <td>{{ $b->nik }}</td>
                        <td>{{ $b->telepon }}</td>
                        <td>Unit {{ $b->unit->nomor_unit ?? '-' }}</td>
                        <td>
                            @if($b->ktp_file)
                                <a href="{{ asset('storage/' . $b->ktp_file) }}" target="_blank" class="btn btn-sm btn-secondary">Lihat KTP</a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($b->bukti_transfer_file)
                                <a href="{{ asset('storage/' . $b->bukti_transfer_file) }}" target="_blank" class="btn btn-sm btn-info text-white">Lihat Struk</a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        
                        <!-- Status Validasi Pembayaran -->
                        <td>
                            @if($b->status_booking == 'Pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif($b->status_booking == 'Dikonfirmasi')
                                <span class="badge bg-success">Dikonfirmasi</span>
                            @else
                                <span class="badge bg-danger">Ditolak</span>
                            @endif
                        </td>

                        <!-- Dropdown & Tombol Simpan Progress Pengajuan -->
                        <td>
                            <form action="{{ route('admin.bookings.updateStatus', $b->id) }}" method="POST" class="d-flex gap-1 align-items-center">
                                @csrf
                                <select name="status" class="form-select form-select-sm fw-bold">
                                    <option value="Booking" {{ $currentStatus == 'booking' ? 'selected' : '' }}>1. Booking</option>
                                    <option value="Proses" {{ $currentStatus == 'proses' ? 'selected' : '' }}>2. Berkas KPR</option>
                                    <option value="Bank" {{ $currentStatus == 'bank' ? 'selected' : '' }}>3. Survey / Bank</option>
                                    <option value="Akad" {{ $currentStatus == 'akad' ? 'selected' : '' }}>4. Akad / Selesai</option>
                                </select>
                                <button type="submit" class="btn btn-primary btn-sm px-2 text-nowrap">Simpan</button>
                            </form>
                        </td>

                        <!-- Aksi Admin -->
                        <td>
                            @if($b->status_booking == 'Pending')
                                <form action="{{ route('admin.bookings.updateStatus', $b->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="action" value="approve">
                                    <button type="submit" class="btn btn-success btn-sm mb-1" onclick="return confirm('Konfirmasi booking ini?')">Setujui</button>
                                </form>
                                <form action="{{ route('admin.bookings.updateStatus', $b->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="action" value="reject">
                                    <button type="submit" class="btn btn-warning btn-sm text-dark mb-1" onclick="return confirm('Tolak booking ini?')">Tolak</button>
                                </form>
                            @endif

                            <a href="{{ route('admin.bookings.edit', $b->id) }}" class="btn btn-warning btn-sm mb-1 text-decoration-none">Edit</a>

                            <form action="{{ route('admin.bookings.destroy', $b->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm mb-1" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="10" class="text-muted py-4">Belum ada data pemesanan unit.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection