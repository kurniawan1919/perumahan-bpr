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
  Schema::create('submissions', function (Blueprint $table) {
        $table->id(); // id (Primary Key, INT, Auto Increment)
        $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade'); // booking_id (Foreign Key ke bookings)
        $table->enum('tahapan_sekarang', [
            'Bi-Checking', 
            'Proses Berkas Bank', 
            'Wawancara', 
            'SP3K', 
            'Akad'
        ])->default('Bi-Checking'); // tahapan_sekarang sesuai catatan[cite: 2]
        $table->text('keterangan_admin')->nullable(); // keterangan_admin (TEXT) untuk catatan kekurangan berkas, dll[cite: 2]
        $table->timestamps(); // timestamps[cite: 2]
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
