<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LayananProduk extends Model
{
    protected $table = 'layanan_produk';
    protected $fillable = ['foto', 'nama', 'deskripsi'];
}
