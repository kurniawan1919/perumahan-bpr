<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\UnitPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminUnitController extends Controller
{
    /**
     * Menampilkan daftar unit rumah.
     */
    public function index()
    {
        $units = Unit::with('photos')->latest()->get();
        return view('admin.units.index', compact('units'));
    }

    /**
     * Menampilkan form tambah unit baru.
     */
    public function create()
    {
        return view('admin.units.create');
    }

    /**
     * Menyimpan data unit baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nomor_unit'    => 'required|string|max:255',
            'tipe'          => 'required|string|max:255',
            'luas_tanah'    => 'required|numeric',
            'luas_bangunan' => 'required|numeric',
            'harga'         => 'required|numeric',
            'status'        => 'required|string',
            'spesifikasi'   => 'required|string',
            'foto'          => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'foto_tambahan.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Simpan foto utama
        $fotoPath = $request->file('foto')->store('units', 'public');

        // Buat data unit baru
        $unit = Unit::create([
            'nomor_unit'    => $request->nomor_unit,
            'tipe'          => $request->tipe,
            'luas_tanah'    => $request->luas_tanah,
            'luas_bangunan' => $request->luas_bangunan,
            'harga'         => $request->harga,
            'status'        => $request->status,
            'spesifikasi'   => $request->spesifikasi,
            'foto'          => $fotoPath,
        ]);

        // Simpan foto galeri tambahan jika ada
        if ($request->hasFile('foto_tambahan')) {
            foreach ($request->file('foto_tambahan') as $file) {
                $path = $file->store('units/gallery', 'public');
                UnitPhoto::create([
                    'unit_id' => $unit->id,
                    'foto'    => $path,
                ]);
            }
        }

        return redirect()->route('admin.units.index')->with('success', 'Unit rumah baru berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit unit.
     */
    public function edit($id)
    {
        $unit = Unit::with('photos')->findOrFail($id);
        return view('admin.units.edit', compact('unit'));
    }

    /**
     * Memperbarui data unit di database.
     */
    public function update(Request $request, $id)
    {
        $unit = Unit::findOrFail($id);

        $request->validate([
            'nomor_unit'    => 'required|string|max:255',
            'tipe'          => 'required|string|max:255',
            'luas_tanah'    => 'required|numeric',
            'luas_bangunan' => 'required|numeric',
            'harga'         => 'required|numeric',
            'status'        => 'required|string',
            'spesifikasi'   => 'required|string',
            'foto'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'foto_tambahan.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = [
            'nomor_unit'    => $request->nomor_unit,
            'tipe'          => $request->tipe,
            'luas_tanah'    => $request->luas_tanah,
            'luas_bangunan' => $request->luas_bangunan,
            'harga'         => $request->harga,
            'status'        => $request->status,
            'spesifikasi'   => $request->spesifikasi,
        ];

        // Jika ada upload foto utama baru
        if ($request->hasFile('foto')) {
            if ($unit->foto && Storage::disk('public')->exists($unit->foto)) {
                Storage::disk('public')->delete($unit->foto);
            }
            $data['foto'] = $request->file('foto')->store('units', 'public');
        }

        $unit->update($data);

        // Tambah foto galeri baru jika diunggah
        if ($request->hasFile('foto_tambahan')) {
            foreach ($request->file('foto_tambahan') as $file) {
                $path = $file->store('units/gallery', 'public');
                UnitPhoto::create([
                    'unit_id' => $unit->id,
                    'foto'    => $path,
                ]);
            }
        }

        return redirect()->route('admin.units.index')->with('success', 'Data unit rumah berhasil diperbarui!');
    }

    /**
     * Menghapus unit rumah beserta foto-fotonya.
     */
    public function destroy($id)
    {
        $unit = Unit::with('photos')->findOrFail($id);

        // Hapus file foto utama dari storage
        if ($unit->foto && Storage::disk('public')->exists($unit->foto)) {
            Storage::disk('public')->delete($unit->foto);
        }

        // Hapus file foto galeri dari storage dan database
        foreach ($unit->photos as $photo) {
            if (Storage::disk('public')->exists($photo->foto)) {
                Storage::disk('public')->delete($photo->foto);
            }
            $photo->delete();
        }

        // Hapus data unit dari database
        $unit->delete();

        return redirect()->route('admin.units.index')->with('success', 'Unit rumah berhasil dihapus!');
    }
}