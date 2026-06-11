<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\PaketLaundry;
use App\Models\TransaksiLaundry;
use App\Models\StatusLaundry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = TransaksiLaundry::with(['pelanggan', 'paketLaundry', 'statusLaundry'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('transaksi.index', compact('transaksis'));
    }

    public function create()
    {
        $pelanggans = Pelanggan::orderBy('nama_pelanggan', 'asc')->get();
        $pakets = PaketLaundry::orderBy('nama_paket', 'asc')->get();
        return view('transaksi.create', compact('pelanggans', 'pakets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'paket_id' => 'required|exists:paket_laundries,id',
            'jumlah_qty' => 'required|integer|min:1',
            'tanggal_masuk' => 'required|date',
            'status_pembayaran' => 'required|in:belum_bayar,lunas',
            'keterangan' => 'nullable|string',
        ]);

        $paket = PaketLaundry::findOrFail($request->paket_id);
        $totalBayar = $request->jumlah_qty * $paket->harga_per_satuan;

        // Generate invoice code: INV-YYYYMMDD-XXXX
        $kodeInvoice = 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(4));

        $transaksi = TransaksiLaundry::create([
            'kode_invoice' => $kodeInvoice,
            'user_id' => Auth::id(),
            'pelanggan_id' => $request->pelanggan_id,
            'paket_id' => $request->paket_id,
            'jumlah_qty' => $request->jumlah_qty,
            'total_bayar' => $totalBayar,
            'tanggal_masuk' => $request->tanggal_masuk,
            'tanggal_ambil' => null,
        ]);

        // Simpan status laundry awal
        StatusLaundry::create([
            'transaksi_id' => $transaksi->id,
            'status_proses' => 'antri',
            'status_pembayaran' => $request->status_pembayaran,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('transaksi.show', $transaksi->id)->with('success', 'Transaksi berhasil dicatat!');
    }

    public function show($id)
    {
        $transaksi = TransaksiLaundry::with(['user', 'pelanggan', 'paketLaundry', 'statusLaundry'])
            ->findOrFail($id);
        return view('transaksi.show', compact('transaksi'));
    }

    public function destroy($id)
    {
        $transaksi = TransaksiLaundry::findOrFail($id);
        $transaksi->delete(); // Karena cascade, data di status_laundries otomatis ikut terhapus
        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus!');
    }
}
