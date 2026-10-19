<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Bumi Parama Residence') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Bootstrap CSS & Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>
    <div id="app">
        <!-- Navbar Utama -->
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand fw-bold text-primary" href="{{ url('/') }}">
                    <i class="bi bi-house-door-fill me-1"></i> Bumi Parama Residence
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar (Menu Publik) -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link fw-semibold" href="{{ route('home') }}">Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-semibold" href="{{ route('units.index') }}">Daftar Unit & Siteplan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-semibold" href="{{ route('simulasi') }}">Simulasi KPR</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-semibold" href="{{ url('/cek-status') }}">Cek Status</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-semibold" href="{{ route('contact') }}">Kontak</a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar (Autentikasi & Panel Admin) -->
                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="btn btn-outline-primary btn-sm px-3 mt-1 fw-bold" href="{{ route('login') }}">
                                        <i class="bi bi-box-arrow-in-right me-1"></i> Login Admin
                                    </a>
                                </li>
                            @endif
                        @else
                            <!-- Dropdown Menu Admin -->
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle fw-bold text-dark bg-light rounded px-3 py-1 mt-1" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="bi bi-shield-lock-fill text-danger me-1"></i> Panel Admin ({{ Auth::user()->name }})
                                </a>

                                <div class="dropdown-menu dropdown-menu-end shadow border-0 py-2" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item fw-bold text-primary py-2" href="{{ route('admin.units.index') }}">
                                        <i class="bi bi-houses me-2"></i> Kelola Unit Rumah
                                    </a>
                                    <a class="dropdown-item fw-bold text-success py-2" href="{{ route('admin.bookings.index') }}">
                                        <i class="bi bi-check2-square me-2"></i> Konfirmasi Booking
                                    </a>
                                    <a class="dropdown-item fw-bold text-info py-2" href="{{ route('admin.contacts.index') }}">
                                        <i class="bi bi-chat-dots me-2"></i> Pesan Masuk Kontak
                                    </a>
                                    <a class="dropdown-item fw-bold text-dark py-2" href="{{ route('admin.password.change') }}">
                                        <i class="bi bi-key me-2 text-warning"></i> Ubah Password
                                    </a>

                                    <div class="dropdown-divider"></div>

                                    <a class="dropdown-item text-danger fw-bold py-2" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="bi bi-box-arrow-right me-2"></i> Keluar (Logout)
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Konten Utama Halaman -->
        <main class="py-4">
            @yield('content')
        </main>

        <!-- Footer Sederhana -->
        <footer class="bg-white text-center text-muted py-4 mt-5 border-top shadow-sm">
            <div class="container">
                <p class="mb-0 small">&copy; {{ date('Y') }} Bumi Parama Residence. All rights reserved.</p>
            </div>
        </footer>
    </div>

    <!-- Bootstrap JS Bundle (Popper + Bootstrap JS) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- ============================================================== -->
    <!-- SCRIPT & AUDIO NOTIFIKASI OTOMATIS (KHUSUS ADMIN/LOGIN)        -->
    <!-- ============================================================== -->
    @auth
        <!-- Elemen Audio (Pastikan file mp3 ada di public/audio/notif.mp3) -->
        <audio id="notif-sound" src="{{ asset('audio/notif.mp3') }}" preload="auto"></audio>

        <script>
            // Minta izin notifikasi browser saat admin membuka halaman
            document.addEventListener("DOMContentLoaded", function () {
                if (Notification.permission !== "granted" && Notification.permission !== "denied") {
                    Notification.requestPermission();
                }
            });

            // Fungsi untuk memutar suara dan memunculkan pop-up notifikasi
            function triggerNotification(pesan) {
                var audio = document.getElementById('notif-sound');
                
                if (audio) {
                    audio.play().catch(error => {
                        console.log("Audio diblokir browser sebelum ada interaksi klik.");
                    });
                }

                if (Notification.permission === "granted") {
                    new Notification("Notifikasi Bumi Parama Residence", {
                        body: pesan
                    });
                }
            }

            // Pengecekan berkala ke server setiap 10 detik
            setInterval(function() {
                fetch("{{ route('admin.cek-notif-baru') }}")
                    .then(response => response.json())
                    .then(data => {
                        if (data.ada_baru) {
                            triggerNotification(data.pesan);
                            // location.reload(); // Uncomment jika ingin halaman otomatis refresh
                        }
                    })
                    .catch(error => {
                        console.error('Gagal mengecek notifikasi:', error);
                    });
            }, 10000); // 10000 ms = 10 detik
        </script>
    @endauth
</body>
</html>