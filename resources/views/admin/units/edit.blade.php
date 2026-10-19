@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2>EDIT UNIT: {{ $unit->nomor_unit }}</h2>

    <form action="{{ route('admin.units.update', $unit->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label class="form-label">Nomor Unit</label>
            <input type="text" name="nomor_unit" class="form-control" value="{{ $unit->nomor_unit }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Tipe Rumah</label>
            <input type="text" name="tipe" class="form-control" value="{{ $unit->tipe }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Luas Tanah</label>
            <input type="number" name="luas_tanah" class="form-control" value="{{ $unit->luas_tanah }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Luas Bangunan</label>
            <input type="number" name="luas_bangunan" class="form-control" value="{{ $unit->luas_bangunan }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Harga</label>
            <input type="number" name="harga" class="form-control" value="{{ $unit->harga }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-control">
                <option value="Ready" {{ $unit->status == 'Ready' ? 'selected' : '' }}>Ready</option>
                <option value="Booking" {{ $unit->status == 'Booking' ? 'selected' : '' }}>Booking</option>
                <option value="Proses" {{ $unit->status == 'Proses' ? 'selected' : '' }}>Proses</option>
                <option value="Akad" {{ $unit->status == 'Akad' ? 'selected' : '' }}>Akad</option>
            </select>
        </div>

        <!-- FOTO UTAMA -->
        <div class="mb-3 p-3 bg-warning text-dark border rounded">
            <label class="form-label fw-bold">GANTI FOTO UTAMA (Opsional):</label>
            @if($unit->foto)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $unit->foto) }}" alt="Foto Lama" width="120" class="img-thumbnail">
                </div>
            @endif
            <input type="file" name="foto" class="form-control" accept="image/*">
        </div>

        <!-- FOTO TAMBAHAN / GALERI -->
        <div class="mb-3 p-3 bg-info text-dark border rounded">
            <label class="form-label fw-bold">TAMBAH FOTO GALERI BARU:</label>
            
            <div id="wrapper-foto">
                <div class="input-group mb-2">
                    <input type="file" name="foto_tambahan[]" class="form-control" accept="image/*">
                </div>
            </div>
            <button type="button" class="btn btn-sm btn-dark mt-2" id="btn-tambah-foto">
                + Tambah Kolom Foto Lain
            </button>
            
            @if($unit->photos && $unit->photos->count() > 0)
                <div class="mt-4">
                    <p class="fw-bold mb-1">Galeri Foto Saat Ini:</p>
                    <div class="row g-2">
                        @foreach($unit->photos as $p)
                        <div class="col-3">
                            <img src="{{ asset('storage/' . $p->foto) }}" class="img-thumbnail" style="height: 80px; width: 100%; object-fit: cover;">
                        </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <div class="mb-3">
            <label class="form-label">Spesifikasi</label>
            <textarea name="spesifikasi" class="form-control" rows="4" required>{{ $unit->spesifikasi }}</textarea>
        </div>

        <button type="submit" class="btn btn-warning btn-lg fw-bold">PERBARUI DATA</button>
        <a href="{{ route('admin.units.index') }}" class="btn btn-secondary btn-lg">Batal</a>
    </form>
</div>

<script>
    document.getElementById('btn-tambah-foto').addEventListener('click', function() {
        let wrapper = document.getElementById('wrapper-foto');
        let div = document.createElement('div');
        div.className = 'input-group mb-2';
        div.innerHTML = `
            <input type="file" name="foto_tambahan[]" class="form-control" accept="image/*">
            <button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.remove()">Hapus</button>
        `;
        wrapper.appendChild(div);
    });
</script>
@endsection