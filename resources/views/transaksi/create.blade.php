@extends('layouts.app')

@section('title', 'Catat Transaksi Baru')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Catat Transaksi Baru ➕</h1>
        <p class="page-subtitle">Buat pesanan laundry baru untuk pelanggan.</p>
    </div>
    <div>
        <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">
            Kembali ke Daftar
        </a>
    </div>
</div>

<div class="card" style="max-width: 800px; margin: 0 auto;">
    <h3 style="margin-bottom: 2rem;">Formulir Pemesanan Laundry</h3>

    <form action="{{ route('transaksi.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="pelanggan_id" class="form-label">Pelanggan</label>
            <select name="pelanggan_id" id="pelanggan_id" class="form-control" required>
                <option value="">-- Pilih Pelanggan --</option>
                @foreach($pelanggans as $p)
                    <option value="{{ $p->id }}">{{ $p->nama_pelanggan }} - ({{ $p->nomor_telepon }})</option>
                @endforeach
            </select>
            @error('pelanggan_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <p style="font-size: 0.85rem; color: var(--text-secondary); margin-top: 0.35rem;">
                Pelanggan belum terdaftar? <a href="{{ route('pelanggan.index') }}" class="link-auth">Tambah Pelanggan Baru</a>
            </p>
        </div>

        <div class="inline-form-row">
            <div class="form-group">
                <label for="paket_id" class="form-label">Pilih Paket Layanan</label>
                <select name="paket_id" id="paket_id" class="form-control" required onchange="calculateTotal()">
                    <option value="">-- Pilih Paket --</option>
                    @foreach($pakets as $p)
                        <option value="{{ $p->id }}" data-price="{{ $p->harga_per_satuan }}" data-unit="{{ $p->jenis_paket == 'kiloan' ? 'Kg' : 'Pcs' }}">
                            {{ $p->nama_paket }} (Rp {{ number_format($p->harga_per_satuan, 0, ',', '.') }}/{{ $p->jenis_paket == 'kiloan' ? 'Kg' : 'Pcs' }})
                        </option>
                    @endforeach
                </select>
                @error('paket_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <p style="font-size: 0.85rem; color: var(--text-secondary); margin-top: 0.35rem;">
                    Katalog paket kosong? <a href="{{ route('paket.index') }}" class="link-auth">Tambah Paket Baru</a>
                </p>
            </div>

            <div class="form-group">
                <label for="jumlah_qty" class="form-label">Jumlah (Quantity)</label>
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <input type="number" name="jumlah_qty" id="jumlah_qty" class="form-control" required min="1" value="1" oninput="calculateTotal()">
                    <span id="unit-label" style="color: var(--text-secondary); font-weight: 600;">Satuan</span>
                </div>
                @error('jumlah_qty')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="inline-form-row">
            <div class="form-group">
                <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
                <input type="datetime-local" name="tanggal_masuk" id="tanggal_masuk" class="form-control" required value="{{ date('Y-m-d\TH:i') }}">
                @error('tanggal_masuk')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="status_pembayaran" class="form-label">Status Pembayaran Awal</label>
                <select name="status_pembayaran" id="status_pembayaran" class="form-control" required>
                    <option value="belum_bayar">Belum Bayar</option>
                    <option value="lunas">Lunas</option>
                </select>
                @error('status_pembayaran')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="keterangan" class="form-label">Keterangan Tambahan (Opsional)</label>
            <textarea name="keterangan" id="keterangan" rows="3" class="form-control" placeholder="Contoh: Baju putih jangan dicampur, pewangi ekstra aroma lavender, dll."></textarea>
        </div>

        <!-- Estimasi Harga Card (Premium UI) -->
        <div class="card" style="background: rgba(255,255,255,0.02); border-color: rgba(255,255,255,0.05); margin-bottom: 2rem; padding: 1.5rem;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-weight: 500; color: var(--text-secondary);">Estimasi Total Bayar:</span>
                <span id="price-estimate" style="font-size: 1.5rem; font-weight: 700; color: #fff; background: linear-gradient(135deg, var(--accent-purple), var(--accent-pink)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Rp 0</span>
            </div>
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%;">
            Catat & Cetak Invoice 🧾
        </button>
    </form>
</div>

<script>
    function calculateTotal() {
        const select = document.getElementById('paket_id');
        const qtyInput = document.getElementById('jumlah_qty');
        const priceEstimate = document.getElementById('price-estimate');
        const unitLabel = document.getElementById('unit-label');

        const selectedOption = select.options[select.selectedIndex];
        
        if (selectedOption && selectedOption.value !== "") {
            const price = parseFloat(selectedOption.getAttribute('data-price'));
            const unit = selectedOption.getAttribute('data-unit');
            const qty = parseFloat(qtyInput.value) || 0;

            const total = price * qty;
            
            // Format to Rupiah
            const formattedTotal = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(total);

            priceEstimate.textContent = formattedTotal;
            unitLabel.textContent = unit;
        } else {
            priceEstimate.textContent = 'Rp 0';
            unitLabel.textContent = 'Satuan';
        }
    }

    // Run once on load to initialize
    window.onload = function() {
        calculateTotal();
    }
</script>
@endsection
