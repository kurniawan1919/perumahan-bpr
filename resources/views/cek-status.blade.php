@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <!-- NOTIFIKASI BERHASIL BOOKING -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4 border-0 rounded-3" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                        <div>
                            <strong>Berhasil!</strong> {{ session('success') }}
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- NOTIFIKASI JIKA ADA ERROR / NIK TIDAK DITEMUKAN -->
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4 border-0 rounded-3" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                        <div>
                            {{ session('error') }}
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4 p-md-5">
                    <h3 class="fw-bold mb-3 text-center">Cek Status Pengajuan Booking</h3>
                    <p class="text-muted text-center mb-4">Masukkan NIK yang Anda gunakan saat mengisi form booking untuk melihat status validasi unit rumah.</p>

                    <!-- Form Pencarian NIK -->
                    <form action="{{ route('submissions.search') }}" method="POST">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="text" name="nik" class="form-control form-control-lg" placeholder="Masukkan 16 digit NIK Anda" required>
                            <button class="btn btn-primary px-4 fw-bold" type="submit">Cek Status</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection