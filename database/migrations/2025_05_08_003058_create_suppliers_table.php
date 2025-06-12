<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menjalankan migrasi: Membuat tabel suppliers.
     */
    public function up(): void
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id(); 

            $table->string('nama'); // Nama supplier

            $table->string('alamat')->nullable(); // Alamat supplier, boleh kosong/null

            $table->string('kode_pos')->nullable(); // Kode pos, boleh kosong/null

            $table->timestamps();
        });
    }

    /**
     * Mengembalikan migrasi: Menghapus tabel suppliers jika rollback.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers'); // Hapus tabel saat rollback
    }
};
