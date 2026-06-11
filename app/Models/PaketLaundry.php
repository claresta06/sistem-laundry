<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['nama_paket', 'jenis_paket', 'harga_per_satuan'])]
class PaketLaundry extends Model
{
    protected $table = 'paket_laundries';

    public function transaksiLaundries()
    {
        return $this->hasMany(TransaksiLaundry::class, 'paket_id');
    }
}
