<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembayaranBukti extends Model
{
    protected $table = 'pembayaran_bukti';
    protected $fillable = ['pembayaran_id', 'bukti'];

    public function pembayaran() {
        return $this->belongsTo('App\Models\Pembayaran');
    }
}
