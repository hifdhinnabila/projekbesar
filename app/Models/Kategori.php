<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategoris';
    protected $fillable = ['nama'];

    //relasi 1 kategori memiliki banyak barang
    public function barangs()
    {
        return $this->hasMany(Barang::class, 'kategori_id');
    }
}
