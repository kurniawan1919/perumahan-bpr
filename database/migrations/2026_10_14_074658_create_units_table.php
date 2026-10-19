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
        Schema::create('units', function (Blueprint $table) {
            $table->id(); // id (Primary Key, INT, Auto Increment)[cite: 2]
            $table->string('nomor_unit'); // nomor_unit (Varchar)[cite: 2]
            $table->string('tipe'); // tipe (Varchar)[cite: 2]
            $table->integer('luas_tanah'); // luas_tanah (INT)[cite: 2]
            $table->integer('luas_bangunan'); // luas_bangunan (INT)[cite: 2]
            $table->decimal('harga', 15, 2); // harga (DECIMAL/BIGINT)[cite: 2]
            $table->enum('status', ['Ready', 'Booking', 'Proses', 'Akad']); // status (Enum)[cite: 2]
            $table->text('spesifikasi'); // spesifikasi (TEXT)[cite: 2]
            $table->string('foto_url')->nullable(); // foto_url (Varchar)[cite: 2]
            $table->string('denah_url')->nullable(); // denah_url (Varchar)[cite: 2]
            $table->timestamps(); // timestamps[cite: 2]
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
