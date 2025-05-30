<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;
    protected $table = 'pembelians';
    protected $fillable = ['barang_id', 'supplier_id', 'jumlah', 'tanggal'];

    //setiap pembelian terkait dengan satu barang.
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    //etiap pembelian terkait dengan satu supplier.
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    //memperbarui stok barang otomatis ketika data pembelian dibuat, dihapus, atau diubah.
    protected static function boot()
    {
        parent::boot();

        //saat data pembelian dibuat, stok barang bertambah sesuai jumlah pembelian
        static::created(function ($pembelian) {
            $pembelian->barang->increment('stok', $pembelian->jumlah);
        });

        //saat data pembelian dihapus, stok barang berkurang sesuai jumlah pembelian yang dihapus
        static::deleted(function ($pembelian) {
            $pembelian->barang->decrement('stok', $pembelian->jumlah);
        });

        //saat data pembelian diupdate, stok barang disesuaikan dengan perubahan jumlah pembelian
        static::updating(function ($pembelian) {
            $original = $pembelian->getOriginal();
            $stokLama = $original['jumlah'];
            $stokBaru = $pembelian->jumlah; 
            
            $pembelian->barang->decrement('stok', $stokLama); //kurangi stok lama terlebih dahulu
            $pembelian->barang->increment('stok', $stokBaru); //tambahkan stok sesuai jumlah baru
        });
    }
}