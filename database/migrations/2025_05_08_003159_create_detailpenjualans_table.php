<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menjalankan migrasi: Membuat tabel detailpenjualans.
     */
    public function up(): void
    {
        Schema::create('detailpenjualans', function (Blueprint $table) {
            $table->id(); 

            // Relasi ke tabel penjualans, jika penjualannya dihapus, data detail ini juga ikut terhapus
            $table->foreignId('penjualan_id')->constrained()->onDelete('cascade');

            // Relasi ke tabel barangs, jika barang dihapus, data detail ini juga ikut terhapus
            $table->foreignId('barang_id')->constrained()->onDelete('cascade');

            $table->integer('jumlah'); // Jumlah barang yang dibeli dalam transaksi
            $table->integer('total_harga')->default(0); // Total harga untuk item ini (jumlah * harga satuan), default 0

            $table->timestamps(); 
        });
    }

    /**
     * Mengembalikan migrasi: Menghapus tabel detailpenjualans jika rollback.
     */
    public function down(): void
    {
        Schema::dropIfExists('detailpenjualans'); // Menghapus tabel saat rollback
    }
};
