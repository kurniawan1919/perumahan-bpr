@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2>TAMBAH UNIT RUMAH BARU</h2>

    <form action="{{ route('admin.units.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="mb-3">
            <label class="form-label">Nomor Unit / Kavling</label>
            <input type="text" name="nomor_unit" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Tipe Rumah</label>
            <input type="text" name="tipe" class="form-control" placeholder="Contoh: Tipe 36/60" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Luas Tanah (m²)</label>
            <input type="number" name="luas_tanah" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Luas Bangunan (m²)</label>
            <input type="number" name="luas_bangunan" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Harga (Rp)</label>
            <input type="number" name="harga" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-control">
                <option value="Ready">Ready</option>
                <option value="Booking">Booking</option>
                <option value="Proses">Proses</option>
                <option value="Akad">Akad</option>
            </select>
        </div>

        <!-- FOTO UTAMA -->
        <div class="mb-3 p-3 bg-light border rounded">
            <label class="form-label fw-bold">Foto Utama Rumah</label>
            <input type="file" name="foto" class="form-control" accept="image/*" required>
        </div>

        <!-- FOTO TAMBAHAN / GALERI -->
        <div class="mb-3 p-3 bg-light border rounded">
            <label class="form-label fw-bold text-dark">Galeri Foto Tambahan</label>
            <div id="wrapper-foto">
                <div class="input-group mb-2">
                    <input type="file" name="foto_tambahan[]" class="form-control" accept="image/*">
                </div>
            </div>
            <button type="button" class="btn btn-sm btn-success mt-2" id="btn-tambah-foto">
                + Tambah Kolom Foto Lain
            </button>
        </div>

        <div class="mb-3">
            <label class="form-label">Spesifikasi</label>
            <textarea name="spesifikasi" class="form-control" rows="4" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary btn-lg fw-bold">SIMPAN DATA</button>
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