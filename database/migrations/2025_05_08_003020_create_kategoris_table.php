<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menjalankan migrasi: membuat tabel kategoris.
     */
    public function up(): void
    {
        Schema::create('kategoris', function (Blueprint $table) {
            $table->id(); 
            
            $table->string('nama')->unique(); // Nama kategori, harus unik agar tidak ada duplikat
            
            $table->timestamps(); 
        });
    }

    /**
     * Membalik migrasi: menghapus tabel kategoris jika rollback.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategoris'); // Menghapus tabel kategoris jika dibatalkan
    }
};
