<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;
    protected $fillable = ['pembeli_id', 'kasir_id', 'tanggal_pesan'];

    //relasi 1 penjualan bisa memiliki banyak detail penjualan.
    public function detailPenjualans()
    {
        return $this->hasMany(DetailPenjualan::class, 'penjualan_id');
    }

    //setiap penjualan terkait dengan satu pembeli.
    public function pembeli()
    {
        return $this->belongsTo(Pembeli::class, 'pembeli_id');
    }

    //setiap penjualan dicatat oleh satu kasir.
    public function kasir()
    {
        return $this->belongsTo(Login::class, 'kasir_id');
    }

    //Menghitung total harga dengan menjumlahkan (jumlah * harga) dari semua detail penjualan.
    public function getTotalHargaAttribute()
    {
        return $this->detailPenjualans->sum(function ($detail) {
            return $detail->jumlah * $detail->harga;
        });
    }
}
