<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detailpenjualan extends Model
{
    use HasFactory;
    protected $table = 'detailpenjualans';
    protected $fillable = ['penjualan_id', 'barang_id', 'jumlah', 'total_harga'];

    //setiap detail penjualan ini milik satu penjualan utama
    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class);
    }

    //setiap detail penjualan berhubungan dengan satu barang
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    //atribut untuk menghitung 'subtotal' otomatis berdasarkan jumlah × harga barang
    public function getSubtotalAttribute()
    {
        return $this->jumlah * $this->harga;
    }
}
