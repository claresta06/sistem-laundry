<?php

namespace App\Http\Controllers;

use App\Models\StatusLaundry;
use App\Models\TransaksiLaundry;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function update(Request $request, $id)
    {
        $request->validate([
            'status_proses' => 'required|in:antri,dicuci,dikeringkan,selesai',
            'status_pembayaran' => 'required|in:belum_bayar,lunas',
            'keterangan' => 'nullable|string',
        ]);

        $status = StatusLaundry::findOrFail($id);
        $status->update([
            'status_proses' => $request->status_proses,
            'status_pembayaran' => $request->status_pembayaran,
            'keterangan' => $request->keterangan,
        ]);

        // Jika status_proses diubah menjadi selesai, set tanggal_ambil di transaksi
        $transaksi = TransaksiLaundry::findOrFail($status->transaksi_id);
        if ($request->status_proses === 'selesai') {
            if (!$transaksi->tanggal_ambil) {
                $transaksi->update(['tanggal_ambil' => now()]);
            }
        } else {
            // Jika dikembalikan dari selesai ke yang lain, kosongkan tanggal_ambil
            $transaksi->update(['tanggal_ambil' => null]);
        }

        return redirect()->back()->with('success', 'Status laundry berhasil diperbarui!');
    }
}
