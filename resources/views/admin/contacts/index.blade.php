@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h2 class="fw-bold">Pesan Masuk dari Konsumen</h2>
            <p class="text-muted">Daftar pertanyaan atau pesan yang dikirim melalui halaman kontak.</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Panel Booking
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama Pengirim</th>
                            <th>Kontak (Email / Telp)</th>
                            <th>Pesan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contacts as $index => $contact)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><small class="text-muted">{{ $contact->created_at->format('d M Y, H:i') }}</small></td>
                            <td class="fw-bold">{{ $contact->nama }}</td>
                            <td>
                                <div><i class="bi bi-envelope me-1 text-primary"></i> {{ $contact->email }}</div>
                                <div><i class="bi bi-whatsapp me-1 text-success"></i> {{ $contact->telepon }}</div>
                            </td>
                            <td><p class="mb-0 text-muted small" style="max-width: 300px;">{{ $contact->pesan }}</p></td>
                            <td class="text-center">
                                <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pesan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus Pesan">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Belum ada pesan masuk dari konsumen.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection