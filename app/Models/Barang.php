<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $table = 'barangs';
    protected $fillable = ['nama', 'gambar', 'kategori_id', 'stok', 'harga'];

    //relasi 1 barang memiliki 1 kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    //relasi 1 barang bisa punya banyak data pembelian
    public function pembelian()
    {
        return $this->hasMany(Pembelian::class, 'barang_id');
    }

    //relasi 1 barang bisa masuk ke banyak transaksi penjualan
    public function detailPenjualan()
    {
        return $this->hasMany(DetailPenjualan::class, 'barang_id');
    }
}
