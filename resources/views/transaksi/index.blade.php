@extends('layouts.app')

@section('title', 'Riwayat Transaksi')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Transaksi Laundry 🧾</h1>
        <p class="page-subtitle">Daftar riwayat seluruh transaksi pelayanan laundry.</p>
    </div>
    <div>
        <a href="{{ route('transaksi.create') }}" class="btn btn-primary">
            <span>➕</span> Catat Transaksi Baru
        </a>
    </div>
</div>

<div class="card">
    <h3 style="margin-bottom: 1.5rem;">Riwayat Transaksi</h3>

    <div class="table-container">
        @if($transaksis->isEmpty())
            <div class="text-center" style="padding: 2rem; color: var(--text-secondary);">
                Belum ada transaksi tercatat.
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
                        <th>Tanggal Masuk</th>
                        <th>Status Proses</th>
                        <th>Status Bayar</th>
                        <th style="width: 180px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaksis as $t)
                        <tr>
                            <td style="font-weight: 600; color: #fff;">{{ $t->kode_invoice }}</td>
                            <td>{{ $t->pelanggan->nama_pelanggan }}</td>
                            <td>{{ $t->paketLaundry->nama_paket }}</td>
                            <td>{{ $t->jumlah_qty }} {{ $t->paketLaundry->jenis_paket == 'kiloan' ? 'Kg' : 'Pcs' }}</td>
                            <td>Rp {{ number_format($t->total_bayar, 0, ',', '.') }}</td>
                            <td>{{ $t->tanggal_masuk->format('d M Y H:i') }}</td>
                            <td>
                                <span class="badge badge-{{ $t->statusLaundry->status_proses }}">
                                    {{ $t->statusLaundry->status_proses }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-{{ $t->statusLaundry->status_pembayaran }}">
                                    {{ str_replace('_', ' ', $t->statusLaundry->status_pembayaran) }}
                                </span>
                            </td>
                            <td>
                                <div style="display: flex; gap: 0.5rem;">
                                    <a href="{{ route('transaksi.show', $t->id) }}" class="btn btn-secondary btn-sm">
                                        🔎 Detail
                                    </a>
                                    <form action="{{ route('transaksi.destroy', $t->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini? Data status terkait juga akan dihapus secara cascade!')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            🗑️ Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection
