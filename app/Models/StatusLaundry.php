<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['transaksi_id', 'status_proses', 'status_pembayaran', 'keterangan'])]
class StatusLaundry extends Model
{
    protected $table = 'status_laundries';

    public function transaksiLaundry()
    {
        return $this->belongsTo(TransaksiLaundry::class, 'transaksi_id');
    }
}
