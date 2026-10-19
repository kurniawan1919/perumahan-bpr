@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center my-4">
        <div class="col-md-5">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <div class="bg-danger text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="bi bi-shield-lock-fill fs-3"></i>
                        </div>
                        <h3 class="fw-bold">Reset Password Aman</h3>
                        <p class="text-muted small">Membutuhkan email terdaftar dan Kode Rahasia Administrator.</p>
                    </div>

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

                    <form action="{{ route('password.email') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-bold">Email Admin Terdaftar</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="admin@parama.com">
                        </div>

                        <!-- KOLOM KODE RAHASIA KEAMANAN -->
                        <div class="mb-3">
                            <label class="form-label fw-bold text-danger">Kode Rahasia Keamanan</label>
                            <input type="password" name="secret_key" class="form-control" required placeholder="Masukkan kode rahasia khusus">
                            <div class="form-text small text-muted">Hanya developer yang mengetahui kode rahasia ini.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Password Baru</label>
                            <input type="password" name="password" class="form-control" required placeholder="Minimal 8 karakter">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="form-control" required placeholder="Ulangi password baru">
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary fw-bold py-2 shadow-sm">
                                Reset Password Sekarang
                            </button>
                            <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-sm border-0 mt-2">
                                <i class="bi bi-arrow-left me-1"></i> Kembali ke Halaman Login
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection