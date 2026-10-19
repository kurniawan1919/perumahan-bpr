@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center my-5">
        <div class="col-md-5">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="bi bi-shield-lock-fill fs-3"></i>
                        </div>
                        <h3 class="fw-bold">Login Developer</h3>
                        <p class="text-muted small">Masuk untuk mengelola unit, validasi booking, dan status pengajuan KPR.</p>
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

                    <form action="{{ route('login') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-bold">Email Admin</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="email" class="form-control border-start-0 bg-light" value="{{ old('email') }}" required autofocus placeholder="admin@parama.com">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-key"></i></span>
                                <input type="password" name="password" class="form-control border-start-0 bg-light" required placeholder="Masukkan password">
                            </div>
                        </div>

                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label small" for="remember">
                                Ingat saya di perangkat ini
                            </label>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary fw-bold py-2 shadow-sm">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Masuk ke Panel Admin
                            </button>
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm border-0 mt-2">
                                <i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda Konsumen
                            </a>
                        </div>
                        <!-- Di bawah form password atau di dekat tombol remember me -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
        <label class="form-check-label small" for="remember">
            Ingat saya
        </label>
    </div>
    <a href="{{ route('password.request') }}" class="small text-decoration-none text-primary fw-bold">Lupa Password?</a>
</div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection