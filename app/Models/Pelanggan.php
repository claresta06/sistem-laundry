<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['nama_pelanggan', 'nomor_telepon', 'alamat'])]
class Pelanggan extends Model
{
    protected $table = 'pelanggans';

    public function transaksiLaundries()
    {
        return $this->hasMany(TransaksiLaundry::class, 'pelanggan_id');
    }
}
