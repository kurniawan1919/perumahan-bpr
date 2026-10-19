<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    // Menampilkan halaman kontak (untuk publik)
    public function index()
    {
        return view('contact');
    }

    // Menyimpan pesan yang dikirim oleh konsumen ke database
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
            'telepon' => 'required|string|max:15',
            'pesan' => 'required|string',
        ], [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'telepon.required' => 'Nomor WhatsApp/Telepon wajib diisi.',
            'pesan.required' => 'Pesan atau pertanyaan wajib diisi.',
        ]);

        // Simpan ke database
        Contact::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'pesan' => $request->pesan,
        ]);

        return redirect()->route('contact')->with('success', 'Pesan Anda berhasil dikirim! Tim marketing kami akan segera menghubungi Anda.');
    }

    // Menampilkan daftar pesan di Panel Admin
    public function adminIndex()
    {
        $contacts = Contact::latest()->get();
        return view('admin.contacts.index', compact('contacts'));
    }

    // Menghapus pesan (opsional untuk admin)
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()->route('admin.contacts.index')->with('success', 'Pesan berhasil dihapus.');
    }
}