<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;


#Fillable(['kode_invoice', 'user_id', 'pelanggan_id', 'paket_id', 'jumlah_qty', 'total_bayar', 'tanggal_masuk', 'tanggal_ambil'])]
class TransaksiLaundry extends Model

{

    protected $table = 'transaksi_laundries';

    protected $casts = [
        'tanggal_masuk' => 'datetime',
        'tanggal_ambil' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    }

    public function paketLaundry()
    {
        return $this->belongsTo(PaketLaundry::class, 'paket_id');
    }

    public function statusLaundry()
    {
        return $this->hasOne(StatusLaundry::class, 'transaksi_id');
    }

}