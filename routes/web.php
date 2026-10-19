<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminUnitController;
use App\Http\Controllers\AdminBookingController;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| 1. RUTE PUBLIK (Dapat Diakses Siapa Saja / Tanpa Login)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/units', [UnitController::class, 'index'])->name('units.index');
Route::get('/simulasi', function () {
    return view('simulasi');
})->name('simulasi');

// Rute Booking Konsumen
Route::get('/booking/{id}', [BookingController::class, 'create'])->name('booking.create');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');

// Rute Cek Status Konsumen
Route::get('/cek-status', [SubmissionController::class, 'index']);
Route::post('/cek-status', [SubmissionController::class, 'search'])->name('submissions.search');

// Rute Halaman Kontak & Kirim Pesan
Route::get('/kontak', [ContactController::class, 'index'])->name('contact');
Route::post('/kontak', [ContactController::class, 'store'])->name('contact.store');


/*
|--------------------------------------------------------------------------
| 2. RUTE AUTENTIKASI (Login, Logout, & Lupa Password)
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rute Lupa Password Aman (Dengan Kode Rahasia)
Route::get('/forgot-password', [LoginController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [LoginController::class, 'processForgotPassword'])->name('password.email');


/*
|--------------------------------------------------------------------------
| 3. RUTE KHUSUS ADMIN / DEVELOPER (DIKUNCI KETAT DENGAN MIDDLEWARE 'AUTH')
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    // Kelola Unit Rumah (Create, Edit, Update, Delete)
    Route::resource('units', AdminUnitController::class);

    // Kelola Booking & Validasi Pembayaran
    Route::get('bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::get('bookings/{id}/edit', [AdminBookingController::class, 'edit'])->name('bookings.edit');
    Route::put('bookings/{id}', [AdminBookingController::class, 'update'])->name('bookings.update');
    Route::post('bookings/{id}/update', [AdminBookingController::class, 'updateStatus'])->name('bookings.updateStatus');
    Route::delete('bookings/{id}', [AdminBookingController::class, 'destroy'])->name('bookings.destroy');

    // Kelola Pesan Masuk dari Halaman Kontak
    Route::get('contacts', [ContactController::class, 'adminIndex'])->name('contacts.index');
    Route::delete('contacts/{id}', [ContactController::class, 'destroy'])->name('contacts.destroy');

    // Ubah Password Admin (Saat Sudah Login)
    Route::get('change-password', [LoginController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('change-password', [LoginController::class, 'updatePassword'])->name('password.update');
});

use App\Models\Booking;

Route::get('/admin/cek-notif-baru', function () {
    // Mengecek apakah ada booking baru yang masuk dalam 15 detik terakhir
    $adaBaru = Booking::where('created_at', '>=', now()->subSeconds(15))->exists();

    return response()->json([
        'ada_baru' => $adaBaru,
        'pesan' => 'Ada konsumen baru yang melakukan booking unit rumah!'
    ]);
})->name('admin.cek-notif-baru');