@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="text-center fw-bold mb-4">Cek Status Pengajuan KPR / Booking</h2>

            <!-- NOTIFIKASI BERHASIL BOOKING (PENTING AGAR MUNCUL) -->
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

            <!-- Form Pencarian -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <form action="{{ route('submissions.search') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="keyword" class="form-label fw-bold">Masukkan NIK atau Nomor Telepon Anda:</label>
                            <div class="input-group">
                                <input type="text" name="keyword" id="keyword" class="form-control form-control-lg" placeholder="Contoh: 3204xxxxxxxxxxxx atau 08123456789" required value="{{ old('keyword', request('keyword')) }}">
                                <button type="submit" class="btn btn-primary btn-lg px-4">Cek Status</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @if(session('error'))
                <div class="alert alert-danger text-center">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Hasil Pencarian -->
            @if(isset($booking))
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-bold">Detail Pengajuan: {{ $booking->nama_lengkap }}</h5>
                </div>
                <div class="card-body p-4">
                    <!-- Informasi Pemesan & Unit -->
                    <div class="row mb-4">
                        <div class="col-md-6 mb-2">
                            <strong>Nomor Unit:</strong>
                            <p class="fs-5 text-primary fw-bold mb-0">Unit {{ $booking->unit->nomor_unit ?? '-' }}</p>
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong>Status Pembayaran Booking:</strong>
                            <p class="mb-0">
                                @if($booking->status_booking == 'Pending')
                                    <span class="badge bg-warning text-dark fs-6">Menunggu Verifikasi Admin</span>
                                @elseif($booking->status_booking == 'Dikonfirmasi')
                                    <span class="badge bg-success fs-6">Dikonfirmasi / Pembayaran Valid</span>
                                @else
                                    <span class="badge bg-danger fs-6">Ditolak</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <hr>

                    <!-- Progress Stepper Pengajuan -->
                    <h5 class="fw-bold mb-3 mt-4 text-center">Progress Tahapan Pengajuan</h5> <br>

                    @php
                        $statusMap = [
                            'booking' => 1,
                            'proses'  => 2,
                            'bank'    => 3,
                            'akad'    => 4,
                        ];
                        $currentStep = $statusMap[strtolower(trim($booking->status ?? 'booking'))] ?? 1;
                    @endphp

                    <div class="position-relative m-4">
                        <div class="progress" style="height: 4px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ ($currentStep - 1) * 33.33 }}%;"></div>
                        </div>
                        <div class="d-flex justify-content-between position-absolute top-0 start-0 w-100 translate-middle-y">
                            <!-- Step 1 -->
                            <div class="text-center">
                                <div class="rounded-circle btn btn-sm {{ $currentStep >= 1 ? 'btn-success' : 'btn-secondary' }}" style="width: 2rem; height: 2rem;">1</div>
                                <div class="small fw-bold mt-1">Booking</div>
                            </div>
                            <!-- Step 2 -->
                            <div class="text-center">
                                <div class="rounded-circle btn btn-sm {{ $currentStep >= 2 ? 'btn-success' : 'btn-secondary' }}" style="width: 2rem; height: 2rem;">2</div>
                                <div class="small fw-bold mt-1">Berkas KPR</div>
                            </div>
                            <!-- Step 3 -->
                            <div class="text-center">
                                <div class="rounded-circle btn btn-sm {{ $currentStep >= 3 ? 'btn-success' : 'btn-secondary' }}" style="width: 2rem; height: 2rem;">3</div>
                                <div class="small fw-bold mt-1">Survey / Bank</div>
                            </div>
                            <!-- Step 4 -->
                            <div class="text-center">
                                <div class="rounded-circle btn btn-sm {{ $currentStep >= 4 ? 'btn-success' : 'btn-secondary' }}" style="width: 2rem; height: 2rem;">4</div>
                                <div class="small fw-bold mt-1">Akad / Selesai</div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info mt-5 text-center mb-0">
                        <strong>Keterangan Status Saat Ini:</strong><br>
                        @if($currentStep == 1)
                            Booking unit telah terdaftar. Silakan lengkapi berkas persyaratan KPR Anda.
                        @elseif($currentStep == 2)
                            Berkas KPR Anda sedang dalam tahap verifikasi dan pengumpulan dokumen.
                        @elseif($currentStep == 3)
                            Berkas Anda telah diteruskan ke Bank untuk proses survey dan analisa persetujuan KPR.
                        @elseif($currentStep == 4)
                            Selamat! Pengajuan KPR Anda telah disetujui. Tahap selanjutnya adalah penandatanganan Akad Kredit.
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection