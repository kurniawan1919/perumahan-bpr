@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4 p-md-5">
                    <h2 class="fw-bold mb-3 text-center">Simulasi Cicilan KPR</h2>
                    <p class="text-muted text-center mb-4">Estimasi cicilan resmi untuk unit di Bumi Parama Residence.</p>

                    <!-- Informasi Rincian Utama -->
                    <div class="bg-light p-3 rounded-3 mb-4 border">
                        <div class="row text-center">
                            <div class="col-4">
                                <span class="text-muted small d-block">Harga Rumah</span>
                                <strong class="text-dark">Rp 166.000.000</strong>
                            </div>
                            <div class="col-4">
                                <span class="text-muted small d-block">Uang Muka (DP)</span>
                                <strong class="text-dark">Rp 5.660.000</strong>
                            </div>
                            <div class="col-4">
                                <span class="text-muted small d-block">Nominal Kredit</span>
                                <strong class="text-primary">Rp 160.340.000</strong>
                            </div>
                        </div>
                    </div>

                    <!-- Tabel Pilihan Tenor & Cicilan -->
                    <h5 class="fw-bold mb-3">Pilihan Angsuran per Bulan:</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th>Jangka Waktu (Tenor)</th>
                                    <th>Jumlah Bulan</th>
                                    <th>Cicilan / Bulan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="fw-bold">10 Tahun</td>
                                    <td>120 Bulan</td>
                                    <td class="text-success fw-bold">Rp 1.700.654</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">15 Tahun</td>
                                    <td>180 Bulan</td>
                                    <td class="text-success fw-bold">Rp 1.267.958</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">20 Tahun</td>
                                    <td>240 Bulan</td>
                                    <td class="text-success fw-bold">Rp 1.058.173</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="text-center mt-4">
                        <a href="{{ route('units.index') }}" class="btn btn-primary px-4 fw-bold shadow-sm">
                            Lihat Ketersediaan Unit Lainnya
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection