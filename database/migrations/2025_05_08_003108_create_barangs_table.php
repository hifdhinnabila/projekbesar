<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menjalankan migrasi: Membuat tabel barangs.
     */
    public function up(): void
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id(); 
            $table->string('nama'); // Nama barang

            $table->string('gambar')->nullable(); // Nama file gambar barang (boleh kosong/null)

            // Relasi ke tabel kategoris, jika kategori dihapus maka barang juga ikut dihapus
            $table->foreignId('kategori_id')->constrained('kategoris')->onDelete('cascade');

            $table->integer('stok')->default(0); // Jumlah stok barang, default 0

            $table->decimal('harga', 10, 2); // Harga barang dengan 2 digit desimal (misal: 99999999.99)

            $table->timestamps(); 
        });
    }

    /**
     * Membalik migrasi: Menghapus tabel barangs jika rollback.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs'); // Hapus tabel saat rollback
    }
};
