<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * 1. Menampilkan Halaman Login
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('admin.bookings.index');
        }
        return view('auth.login');
    }

    /**
     * 2. Memproses Otentikasi Login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            return redirect()->intended(route('admin.bookings.index'))
                ->with('success', 'Selamat datang kembali, Admin!');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * 3. Memproses Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda telah keluar dari sistem.');
    }

    /**
     * 4. Menampilkan Form Ubah Password (Saat Sudah Login)
     */
    public function showChangePasswordForm()
    {
        return view('auth.change-password');
    }

    /**
     * 5. Memproses Perubahan Password (Saat Sudah Login)
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password baru minimal harus 8 karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        $user = Auth::user();

        // Cek apakah password lama sesuai
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah.']);
        }

        // Update password baru
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('admin.bookings.index')->with('success', 'Password berhasil diperbarui!');
    }

    /**
     * 6. Menampilkan Form Lupa Password (Saat Belum Login)
     */
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * 7. Memproses Reset Password dengan Keamanan Kode Rahasia
     */
    public function processForgotPassword(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
            'secret_key' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'email.exists' => 'Email admin tidak terdaftar di sistem.',
            'secret_key.required' => 'Kode rahasia keamanan wajib diisi.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password baru minimal harus 8 karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        // KODE RAHASIA KEAMANAN (Ubah kodenya sesuai keinginan Anda di sini)
        $validSecretKey = 'parama2026rahasia';

        if ($request->secret_key !== $validSecretKey) {
            return back()->withErrors(['secret_key' => 'Kode rahasia keamanan salah! Akses ditolak.'])->onlyInput('email');
        }

        // Cari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        // Simpan password baru
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('login')->with('success', 'Password berhasil direset! Silakan login dengan password baru Anda.');
    }
}