<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;

class JsonController extends Controller
{
    public function getBarangById($id){
        $barang = Barang::find($id);
        return response()->json($barang);
    }
}