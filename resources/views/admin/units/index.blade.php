@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Kelola Unit Rumah</h2>
        <a href="{{ route('admin.units.create') }}" class="btn btn-primary">Tambah Unit Baru</a>
    </div>

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
                    <th>Nomor Unit</th>
                    <th>Tipe / Harga</th>
                    <th>Status Unit</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($units) && count($units) > 0)
                    @foreach($units as $index => $u)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="fw-bold">Unit {{ $u->nomor_unit ?? '-' }}</td>
                        <td>{{ $u->tipe ?? '-' }} - Rp {{ number_format($u->harga ?? 0, 0, ',', '.') }}</td>
                        
                        <!-- Status Unit yang Dinamis -->
                        <td>
                            @if(strtolower($u->status ?? 'ready') == 'ready')
                                <span class="badge bg-success">Ready</span>
                            @elseif(strtolower($u->status) == 'booking')
                                <span class="badge bg-warning text-dark">Booking</span>
                            @else
                                <span class="badge bg-danger">{{ ucfirst($u->status) }}</span>
                            @endif
                        </td>

                        <td>
                            <a href="{{ route('admin.units.edit', $u->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            
                            <form action="{{ route('admin.units.destroy', $u->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus unit ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-muted py-4">Belum ada data unit rumah yang ditambahkan.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection