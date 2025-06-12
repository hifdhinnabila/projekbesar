<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menjalankan migrasi: Membuat tabel pembelians.
     */
    public function up(): void
    {
        Schema::create('pembelians', function (Blueprint $table) {
            $table->id(); 

            // Relasi ke tabel barangs (barang yang dibeli dari supplier)
            // Jika barang dihapus, data pembelian terkait juga ikut terhapus
            $table->foreignId('barang_id')->constrained('barangs')->onDelete('cascade');

            // Relasi ke tabel suppliers (supplier yang menyediakan barang)
            // Jika supplier dihapus, data pembelian terkait juga ikut terhapus
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade');

            $table->integer('jumlah'); // Jumlah barang yang dibeli
            $table->date('tanggal');   // Tanggal pembelian dilakukan

            $table->timestamps(); 
        });
    }

    /**
     * Mengembalikan migrasi: Menghapus tabel pembelians jika rollback.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelians'); // Hapus tabel jika rollback
    }
};
