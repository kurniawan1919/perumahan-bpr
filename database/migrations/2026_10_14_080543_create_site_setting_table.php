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
Schema::create('site_settings', function (Blueprint $table) {
        $table->id(); // id (Primary Key, INT, Auto Increment)[cite: 2]
        $table->string('key')->unique(); // key (Varchar) untuk nama setting (misal: no_whatsapp, alamat_proyek)[cite: 2]
        $table->text('value'); // value (TEXT) untuk isi dari pengaturannya[cite: 2]
        $table->timestamps(); // timestamps[cite: 2]
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_setting');
    }
};
