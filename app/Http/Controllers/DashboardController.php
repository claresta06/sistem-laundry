<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\TransaksiLaundry;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Total pendapatan dari transaksi yang lunas
        $totalRevenue = TransaksiLaundry::whereHas('statusLaundry', function ($query) {
            $query->where('status_pembayaran', 'lunas');
        })->sum('total_bayar');

        // Jumlah cucian aktif (belum selesai)
        $activeLaundryCount = TransaksiLaundry::whereHas('statusLaundry', function ($query) {
            $query->where('status_proses', '!=', 'selesai');
        })->count();

        // Jumlah pelanggan terdaftar
        $customerCount = Pelanggan::count();

        // Transaksi terbaru (5 terakhir)
        $recentTransactions = TransaksiLaundry::with(['pelanggan', 'paketLaundry', 'statusLaundry'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact('totalRevenue', 'activeLaundryCount', 'customerCount', 'recentTransactions'));
    }
}
