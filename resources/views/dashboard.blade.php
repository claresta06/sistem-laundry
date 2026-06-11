@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Ringkasan Dashboard 📊</h1>
        <p class="page-subtitle">Selamat datang di sistem manajemen laundry Anda.</p>
    </div>
    <div>
        <a href="{{ route('transaksi.create') }}" class="btn btn-primary">
            <span>➕</span> Catat Transaksi Baru
        </a>
    </div>
</div>

<!-- Stats Card Grid -->
<div class="stats-grid">
    <!-- Stat 1: Revenue -->
    <div class="card stat-card">
        <div class="stat-icon">💵</div>
        <div class="stat-info">
            <span class="stat-label">Total Pendapatan</span>
            <span class="stat-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
        </div>
    </div>

    <!-- Stat 2: Active Orders -->
    <div class="card stat-card">
        <div class="stat-icon blue">🔄</div>
        <div class="stat-info">
            <span class="stat-label">Cucian Diproses</span>
            <span class="stat-value">{{ $activeLaundryCount }} Pesanan</span>
        </div>
    </div>

    <!-- Stat 3: Total Customers -->
    <div class="card stat-card">
        <div class="stat-icon green">👥</div>
        <div class="stat-info">
            <span class="stat-label">Jumlah Pelanggan</span>
            <span class="stat-value">{{ $customerCount }} Pelanggan</span>
        </div>
    </div>
</div>

<!-- Recent Transactions -->
<div class="card" style="margin-top: 2rem;">
    <h3 style="margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
        <span>🧾</span> Transaksi Terbaru
    </h3>

    <div class="table-container">
        @if($recentTransactions->isEmpty())
            <div class="text-center" style="padding: 2rem; color: var(--text-secondary);">
                Belum ada data transaksi tercatat.
            </div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Kode Invoice</th>
                        <th>Pelanggan</th>
                        <th>Paket</th>
                        <th>Jumlah Qty</th>
                        <th>Total Bayar</th>
                        <th>Status Proses</th>
                        <th>Status Bayar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentTransactions as $tx)
                        <tr>
                            <td style="font-weight: 600; color: #fff;">{{ $tx->kode_invoice }}</td>
                            <td>{{ $tx->pelanggan->nama_pelanggan }}</td>
                            <td>{{ $tx->paketLaundry->nama_paket }}</td>
                            <td>{{ $tx->jumlah_qty }} {{ $tx->paketLaundry->jenis_paket == 'kiloan' ? 'Kg' : 'Pcs' }}</td>
                            <td>Rp {{ number_format($tx->total_bayar, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge badge-{{ $tx->statusLaundry->status_proses }}">
                                    {{ $tx->statusLaundry->status_proses }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-{{ $tx->statusLaundry->status_pembayaran }}">
                                    {{ str_replace('_', ' ', $tx->statusLaundry->status_pembayaran) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('transaksi.show', $tx->id) }}" class="btn btn-secondary btn-sm">
                                    Detail 🔎
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection
