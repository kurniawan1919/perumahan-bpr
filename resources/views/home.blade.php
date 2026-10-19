@extends('layouts.app')

@section('title', 'Beranda - Perumahan Bumi Parama Residence')

@section('content')

<!-- Hero Section (Banner Utama) -->
<div class="bg-primary text-white py-5 mb-5 shadow">
    <div class="container py-5 text-center">
        <h1 class="display-4 fw-bold mb-3">Temukan Hunian Impian Keluarga Anda</h1>
        <p class="lead mb-4">Perumahan modern, nyaman, dan strategis dengan sistem pemesanan online yang mudah dan transparan.</p>
        <a href="/units" class="btn btn-warning btn-lg fw-bold px-4 shadow-sm">
            <i class="bi bi-grid-3x3-gap-fill me-2"></i>Lihat Daftar Unit & Siteplan
        </a>
    </div>
</div>

<!-- Info Singkat Perumahan -->
<div class="container mb-5">
    <div class="row text-center mb-4">
        <div class="col">
            <h2 class="fw-bold">Mengapa Memilih Perumahan Kami?</h2>
            <p class="text-muted">Fasilitas dan keunggulan utama proyek perumahan kami</p>
        </div>
    </div>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm p-3 text-center">
                <div class="card-body">
                    <div class="fs-1 text-primary mb-3"><i class="bi bi-shield-check"></i></div>
                    <h5 class="card-title fw-bold">Legalitas Aman</h5>
                    <p class="card-text text-muted">Sertipikat Hak Milik (SHM), IMB/PBG sudah pecah per kavling dan siap proses KPR.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm p-3 text-center">
                <div class="card-body">
                    <div class="fs-1 text-primary mb-3"><i class="bi bi-geo-alt-fill"></i></div>
                    <h5 class="card-title fw-bold">Lokasi Strategis</h5>
                    <p class="card-text text-muted">Akses dekat dengan pusat perkotaan, fasilitas pendidikan, pasar, dan jalur transportasi utama.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm p-3 text-center">
                <div class="card-body">
                    <div class="fs-1 text-primary mb-3"><i class="bi bi-wallet2"></i></div>
                    <h5 class="card-title fw-bold">Cicilan Terjangkau</h5>
                    <p class="card-text text-muted">Bekerja sama dengan bank terkemuka untuk memberikan kemudahan proses KPR dan DP ringan.</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection