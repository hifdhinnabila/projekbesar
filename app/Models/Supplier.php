<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $table = 'suppliers';
    protected $fillable = ['nama', 'alamat', 'kode_pos'];

    //relasi 1 supplier bisa memiliki banyak pembelian.
    public function pembelian()
    {
        return $this->hasMany(Pembelian::class, 'supplier_id');
    }
}
