@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- Header Judul -->
    <div class="row mb-5 text-center">
        <div class="col">
            <h2 class="fw-bold">Hubungi Kami</h2>
            <p class="text-muted">Punya pertanyaan seputar unit rumah atau jadwal survei? Jangan ragu untuk menghubungi kami.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-5">
        <!-- Informasi Kontak & Peta -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-light">
                <h4 class="fw-bold mb-4 text-primary">Kantor Pemasaran</h4>
                
                <div class="d-flex mb-3">
                    <div class="me-3 text-primary fs-4"><i class="bi bi-geo-alt-fill"></i></div>
                    <div>
                        <h6 class="fw-bold mb-1">Alamat Lokasi</h6>
                        <p class="text-muted small mb-0">5WF4+X8X, Mekarjaya, Kec. Sumedang Utara, Kabupaten Sumedang, Jawa Barat 45621</p>
                    </div>
                </div>

                <div class="d-flex mb-3">
                    <div class="me-3 text-success fs-4"><i class="bi bi-whatsapp"></i></div>
                    <div>
                        <h6 class="fw-bold mb-1">WhatsApp Marketing</h6>
                        <p class="text-muted small mb-0">089672777529 (Admin)</p>
                    </div>
                </div>

                <div class="d-flex mb-4">
                    <div class="me-3 text-primary fs-4"><i class="bi bi-envelope-fill"></i></div>
                    <div>
                        <h6 class="fw-bold mb-1">Email Resmi</h6>
                        <p class="text-muted small mb-0">info@bumiparamaresidence.com</p>
                    </div>
                </div>

                <!-- Google Maps Embed -->
                <div class="mt-auto">
                    <div class="ratio ratio-16x9 rounded overflow-hidden shadow-sm">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.887414971842!2d107.916!3d-6.858!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwNTEnMjguOCJTIDEwN8KwNTQnNTcuNiJF!5e0!3m2!1sid!2sid!4v1620000000000!5m2!1sid!2sid" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Kirim Pesan -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
                <h4 class="fw-bold mb-3">Kirim Pesan / Konsultasi</h4>
                <p class="text-muted small mb-4">Isi formulir di bawah ini dan tim marketing kami akan segera merespons via WhatsApp atau Email.</p>

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                        <ul class="mb-0 small ps-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('contact.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required placeholder="Contoh: Budi Santoso">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="budi@example.com">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nomor WhatsApp / Telepon</label>
                            <input type="text" name="telepon" class="form-control" value="{{ old('telepon') }}" required placeholder="08123456789">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Pesan / Pertanyaan</label>
                        <textarea name="pesan" class="form-control" rows="5" required placeholder="Tuliskan pertanyaan atau jadwal rencana survei lokasi Anda...">{{ old('pesan') }}</textarea>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="fw-bold py-2 shadow-sm" style="background-color: #25D366; border: none; color: white;">
                            <i class="bi bi-whatsapp me-2"></i> Kirim Pesan via Sistem
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection