<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menjalankan migrasi: Membuat tabel penjualans.
     */
    public function up(): void
    {
        Schema::create('penjualans', function (Blueprint $table) {
            $table->id(); 

            // Relasi ke tabel pembelis (pembeli_id), jika pembeli dihapus maka data penjualan ikut dihapus
            $table->foreignId('pembeli_id')->constrained()->onDelete('cascade');

            // Relasi ke tabel logins sebagai kasir_id, mengacu pada user login yang melakukan transaksi
            $table->foreignId('kasir_id')->constrained('logins')->onDelete('cascade');

            $table->date('tanggal_pesan'); // Menyimpan tanggal transaksi dilakukan

            $table->timestamps(); 
        });
    }

    /**
     * Mengembalikan migrasi: Menghapus tabel penjualans jika rollback.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualans'); // Menghapus tabel saat rollback
    }
};
