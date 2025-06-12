<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menjalankan migrasi: membuat tabel logins.
     */
    public function up(): void
    {
        Schema::create('logins', function (Blueprint $table) {
            $table->id(); 
            
            $table->string('username')->unique(); // Kolom username, harus unik agar tidak ada duplikat akun
            
            $table->string('password'); // Kolom password (disarankan disimpan dalam bentuk hash)
            
            $table->timestamps(); 
        });
    }

    /**
     * Membalik migrasi: menghapus tabel logins jika rollback.
     */
    public function down(): void
    {
        Schema::dropIfExists('logins'); // Menghapus tabel logins jika migrasi dibatalkan
    }
};
