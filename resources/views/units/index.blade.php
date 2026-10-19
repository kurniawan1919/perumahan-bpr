@extends('layouts.app')

@section('title', 'Daftar Unit & Siteplan - Perumahan Bumi Parama Residence')

@section('content')
<div class="container py-5">
    <div class="row mb-4 text-center">
        <div class="col">
            <h2 class="fw-bold">Daftar Unit & Siteplan Perumahan</h2>
            <p class="text-muted">Pilih kavling hunian idaman Anda. Klik foto untuk melihat galeri lengkap.</p>
        </div>
    </div>

    <!-- GAMBAR SITEPLAN PERUMAHAN (Ditambahkan di sini dengan ukuran pas & rapi) -->
    <div class="row mb-5 justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-primary text-white py-3 fw-bold">
                    <i class="bi bi-map-fill me-2"></i> Master Siteplan Perumahan
                </div>
                <div class="card-body p-3 text-center bg-light">
                    <div class="bg-white p-2 rounded shadow-sm d-inline-block" style="max-width: 100%;">
                        <!-- Pastikan file gambar siteplan ada di public/images/siteplan.jpg -->
                        <img src="{{ asset('images/siteplan.jpg') }}" alt="Siteplan Perumahan" class="img-fluid rounded mx-auto d-block" style="max-height: 480px; width: auto; object-fit: contain;">
                    </div>
                    <div class="mt-2 small text-muted">
                        <i class="bi bi-info-circle me-1"></i> Perhatikan blok kavling pada siteplan di atas, lalu cari ketersediaannya pada daftar unit di bawah.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Keterangan Badge Status -->
    <div class="row mb-4 justify-content-center">
        <div class="col-md-8 text-center">
            <span class="badge bg-success mx-1 p-2">Ready (Tersedia)</span>
            <span class="badge bg-warning text-dark mx-1 p-2">Booking (Dipesan)</span>
            <span class="badge bg-info text-dark mx-1 p-2">Proses (Berkas KPR)</span>
            <span class="badge bg-danger mx-1 p-2">Akad (Terjual)</span>
        </div>
    </div>

    <!-- Daftar Kartu Unit -->
    <div class="row g-4">
        @forelse($units as $unit)
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0">
                
                <!-- FOTO UTAMA (Bisa diklik untuk buka modal) -->
                <a href="#" data-bs-toggle="modal" data-bs-target="#modalGaleri{{ $unit->id }}">
                    @if($unit->foto)
                        <img src="{{ asset('storage/' . $unit->foto) }}" class="card-img-top" alt="Foto Rumah" style="height: 200px; object-fit: cover;">
                    @else
                        <img src="https://via.placeholder.com/400x200?text=Tidak+Ada+Foto" class="card-img-top" alt="Default" style="height: 200px; object-fit: cover;">
                    @endif
                </a>
                
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        @if($unit->status == 'Ready')
                            <span class="badge bg-success">Ready</span>
                        @elseif($unit->status == 'Booking')
                            <span class="badge bg-warning text-dark">Booking</span>
                        @elseif($unit->status == 'Proses')
                            <span class="badge bg-info text-dark">Proses</span>
                        @else
                            <span class="badge bg-danger">Akad</span>
                        @endif

                        <h5 class="text-primary fw-bold mb-0">Rp {{ number_format($unit->harga, 0, ',', '.') }}</h5>
                    </div>

                    <h4 class="card-title fw-bold">Unit {{ $unit->nomor_unit }}</h4>
                    <p class="text-muted small mb-2">{{ $unit->tipe }}</p>
                    
                    <p class="card-text small text-secondary">
                        <i class="bi bi-aspect-ratio me-1"></i> Luas Tanah: {{ $unit->luas_tanah }} m² | Luas Bangunan: {{ $unit->luas_bangunan }} m²
                    </p>

                    <!-- Tombol Pemicu Pop-up Galeri -->
                    <button class="btn btn-outline-secondary btn-sm w-100 mb-2" data-bs-toggle="modal" data-bs-target="#modalGaleri{{ $unit->id }}">
                        <i class="bi bi-images me-1"></i> Lihat Galeri Foto ({{ 1 + $unit->photos->count() }})
                    </button>

                    <!-- Tombol Aksi Booking -->
                    @if($unit->status == 'Ready')
                        <a href="/booking/{{ $unit->id }}" class="btn btn-primary w-100 fw-bold">
                            <i class="bi bi-bookmark-check me-1"></i> Booking Unit Ini
                        </a>
                    @else
                        <button class="btn btn-secondary w-100" disabled>Unit Tidak Tersedia</button>
                    @endif
                </div>
            </div>
        </div>

        <!-- MODAL POP-UP GALERI FOTO -->
        <div class="modal fade" id="modalGaleri{{ $unit->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold">Galeri Foto - Unit {{ $unit->nomor_unit }} ({{ $unit->tipe }})</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <!-- Foto Utama -->
                            @if($unit->foto)
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm">
                                    <img src="{{ asset('storage/' . $unit->foto) }}" class="card-img-top rounded" style="height: 220px; object-fit: cover;" alt="Foto Utama">
                                    <div class="card-body p-2 text-center">
                                        <span class="badge bg-primary">Foto Utama</span>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Foto-foto Tambahan -->
                            @foreach($unit->photos as $p)
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm">
                                    <img src="{{ asset('storage/' . $p->foto) }}" class="card-img-top rounded" style="height: 220px; object-fit: cover;" alt="Foto Galeri">
                                    <div class="card-body p-2 text-center">
                                        <span class="badge bg-secondary">Foto Sudut Lain</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="alert alert-warning py-4 shadow-sm" role="alert">
                    <h5 class="fw-bold">Belum ada data unit rumah yang dimasukkan.</h5>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection