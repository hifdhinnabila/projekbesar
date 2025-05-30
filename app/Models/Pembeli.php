<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembeli extends Model
{
    use HasFactory;
    protected $table = 'pembelis';
    protected $fillable = ['nama', 'jenis_kelamin', 'alamat', 'no_hp'];

    //relasi 1 pembeli bisa memiliki banyak penjualan
    public function penjualans()
    {
        return $this->hasMany(Penjualan::class, 'pembeli_id');
    }
}
