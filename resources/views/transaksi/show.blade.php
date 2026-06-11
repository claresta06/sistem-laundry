@extends('layouts.app')

@section('title', 'Detail Transaksi ' . $transaksi->kode_invoice)

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Detail Transaksi 🔎</h1>
        <p class="page-subtitle">Informasi lengkap transaksi {{ $transaksi->kode_invoice }}.</p>
    </div>
    <div>
        <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">
            Kembali ke Riwayat
        </a>
    </div>
</div>

<div class="grid-2col">
    <!-- Left Column: Printable Invoice Bill -->
    <div>
        <div class="card invoice-card" id="printable-invoice">
            <div class="invoice-header">
                <div class="invoice-title">LAUNDRYGLOW</div>
                <div style="font-size: 0.8rem; text-transform: uppercase;">Sistem Pelayanan Laundry Modern</div>
                <div style="font-size: 0.8rem; margin-top: 0.25rem;">Jl. Raya Laundry No. 77, Indonesia</div>
                <div style="font-size: 0.8rem;">Telp: 0812-3456-7890</div>
            </div>

            <div style="border-bottom: 1px dashed rgba(255, 255, 255, 0.15); padding-bottom: 1rem; margin-bottom: 1rem;">
                <div class="invoice-detail-row">
                    <span>No. Invoice:</span>
                    <span style="font-weight: 700;">{{ $transaksi->kode_invoice }}</span>
                </div>
                <div class="invoice-detail-row">
                    <span>Tanggal Masuk:</span>
                    <span>{{ $transaksi->tanggal_masuk->format('d/m/Y H:i') }}</span>
                </div>
                <div class="invoice-detail-row">
                    <span>Tanggal Ambil:</span>
                    <span>{{ $transaksi->tanggal_ambil ? $transaksi->tanggal_ambil->format('d/m/Y H:i') : '-' }}</span>
                </div>
                <div class="invoice-detail-row">
                    <span>Kasir:</span>
                    <span>{{ $transaksi->user->name }}</span>
                </div>
            </div>

            <div style="border-bottom: 1px dashed rgba(255, 255, 255, 0.15); padding-bottom: 1rem; margin-bottom: 1rem;">
                <div class="invoice-detail-row" style="font-weight: 700; color: #fff;">
                    <span>Pelanggan:</span>
                    <span>{{ $transaksi->pelanggan->nama_pelanggan }}</span>
                </div>
                <div class="invoice-detail-row">
                    <span>Telepon:</span>
                    <span>{{ $transaksi->pelanggan->nomor_telepon }}</span>
                </div>
                <div class="invoice-detail-row">
                    <span>Alamat:</span>
                    <span style="max-width: 250px; text-align: right; word-wrap: break-word;">{{ $transaksi->pelanggan->alamat }}</span>
                </div>
            </div>

            <div>
                <div class="invoice-detail-row" style="font-weight: 700; color: #fff; margin-bottom: 1rem;">
                    <span>Item Layanan</span>
                    <span>Tarif</span>
                </div>
                
                <div class="invoice-detail-row">
                    <span>
                        {{ $transaksi->paketLaundry->nama_paket }}<br>
                        <small style="color: var(--text-secondary);">
                            {{ $transaksi->jumlah_qty }} {{ $transaksi->paketLaundry->jenis_paket == 'kiloan' ? 'Kg' : 'Pcs' }} x Rp {{ number_format($transaksi->paketLaundry->harga_per_satuan, 0, ',', '.') }}
                        </small>
                    </span>
                    <span>Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</span>
                </div>

                <div class="invoice-total-row">
                    <span>TOTAL BAYAR:</span>
                    <span>Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</span>
                </div>
            </div>

            <div style="text-align: center; font-size: 0.8rem; margin-top: 2rem;">
                <p>--- Terima Kasih ---</p>
                <p>Pakaian Anda Adalah Kebanggaan Kami</p>
            </div>
        </div>

        <div style="margin-top: 1.5rem; display: flex; gap: 1rem;">
            <button onclick="window.print()" class="btn btn-primary" style="flex: 1;">
                🖨️ Cetak Invoice (Struk)
            </button>
        </div>
    </div>

    <!-- Right Column: Status Update Management Form -->
    <div class="card">
        <h3 style="margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
            <span>⚙️</span> Kelola Status Laundry
        </h3>

        <form action="{{ route('status.update', $transaksi->statusLaundry->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="status_proses" class="form-label">Status Proses Pengerjaan</label>
                <select name="status_proses" id="status_proses" class="form-control" required>
                    <option value="antri" {{ $transaksi->statusLaundry->status_proses == 'antri' ? 'selected' : '' }}>1. Antri (Menunggu)</option>
                    <option value="dicuci" {{ $transaksi->statusLaundry->status_proses == 'dicuci' ? 'selected' : '' }}>2. Dicuci (Proses Cuci)</option>
                    <option value="dikeringkan" {{ $transaksi->statusLaundry->status_proses == 'dikeringkan' ? 'selected' : '' }}>3. Dikeringkan (Proses Pengeringan/Setrika)</option>
                    <option value="selesai" {{ $transaksi->statusLaundry->status_proses == 'selesai' ? 'selected' : '' }}>4. Selesai (Siap Diambil)</option>
                </select>
            </div>

            <div class="form-group">
                <label for="status_pembayaran" class="form-label">Status Pembayaran</label>
                <select name="status_pembayaran" id="status_pembayaran" class="form-control" required>
                    <option value="belum_bayar" {{ $transaksi->statusLaundry->status_pembayaran == 'belum_bayar' ? 'selected' : '' }}>Belum Bayar</option>
                    <option value="lunas" {{ $transaksi->statusLaundry->status_pembayaran == 'lunas' ? 'selected' : '' }}>Lunas</option>
                </select>
            </div>

            <div class="form-group">
                <label for="keterangan" class="form-label">Catatan/Keterangan Proses</label>
                <textarea name="keterangan" id="keterangan" rows="4" class="form-control" placeholder="Tulis catatan jika ada perkembangan pengerjaan...">{{ $transaksi->statusLaundry->keterangan }}</textarea>
            </div>

            <div style="border-top: 1px solid var(--border-glass); padding-top: 1.5rem; margin-top: 1.5rem;">
                <div style="display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 1.5rem;">
                    <div style="display: flex; justify-content: space-between;">
                        <span>Status Saat Ini:</span>
                        <span class="badge badge-{{ $transaksi->statusLaundry->status_proses }}">
                            {{ $transaksi->statusLaundry->status_proses }}
                        </span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span>Status Bayar:</span>
                        <span class="badge badge-{{ $transaksi->statusLaundry->status_pembayaran }}">
                            {{ str_replace('_', ' ', $transaksi->statusLaundry->status_pembayaran) }}
                        </span>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%;">
                    Update Status Pesanan 💾
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
