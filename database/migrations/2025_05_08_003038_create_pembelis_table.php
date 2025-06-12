<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menjalankan migrasi: Membuat tabel pembelis.
     */
    public function up(): void
    {
        Schema::create('pembelis', function (Blueprint $table) {
            $table->id(); 

            $table->string('nama'); // Nama pembeli

            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']); // Pilihan gender hanya antara Laki-laki atau Perempuan

            $table->text('alamat')->nullable(); // Alamat pembeli (boleh kosong/null)

            $table->string('no_hp')->unique(); // Nomor HP unik, tidak boleh sama dengan pembeli lain

            $table->timestamps(); 
        });
    }

    /**
     * Membalik migrasi: Menghapus tabel pembelis jika rollback.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelis'); // Drop tabel jika migrasi dibatalkan
    }
};
