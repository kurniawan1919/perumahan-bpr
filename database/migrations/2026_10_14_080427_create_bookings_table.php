<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
        $table->id(); // id (Primary Key, INT, Auto Increment)
        $table->foreignId('unit_id')->constrained('units')->onDelete('cascade'); // unit_id (Relasi ke tabel units)
        $table->string('nama_lengkap'); // Nama lengkap calon pembeli
        $table->string('nik'); // Nomor NIK KTP
        $table->string('telepon'); // Nomor telepon / WhatsApp
        $table->string('ktp_file'); // Path file foto/scan KTP
        $table->string('bukti_transfer_file'); // Path file bukti transfer booking fee
        $table->enum('status_booking', ['Pending', 'Dikonfirmasi', 'Ditolak'])->default('Pending'); // Status konfirmasi admin
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
