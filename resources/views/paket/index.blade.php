@extends('layouts.app')

@section('title', 'Katalog Paket Laundry')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Katalog Paket Laundry 🧺</h1>
        <p class="page-subtitle">Kelola daftar layanan paket laundry kiloan atau satuan.</p>
    </div>
</div>

<div class="grid-2col">
    <!-- Left Column: Package List Table -->
    <div class="card">
        <h3 style="margin-bottom: 1.5rem;">Daftar Paket</h3>
        
        <div class="table-container">
            @if($pakets->isEmpty())
                <div class="text-center" style="padding: 2rem; color: var(--text-secondary);">
                    Belum ada paket laundry terdaftar.
                </div>
            @else
                <table>
                    <thead>
                        <tr>
                            <th>Nama Paket</th>
                            <th>Jenis Paket</th>
                            <th>Harga per Satuan</th>
                            <th style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pakets as $p)
                            <tr>
                                <td style="font-weight: 600; color: #fff;">{{ $p->nama_paket }}</td>
                                <td>
                                    <span class="badge {{ $p->jenis_paket == 'kiloan' ? 'badge-dicuci' : 'badge-dikeringkan' }}">
                                        {{ ucfirst($p->jenis_paket) }}
                                    </span>
                                </td>
                                <td>Rp {{ number_format($p->harga_per_satuan, 0, ',', '.') }}</td>
                                <td>
                                    <div style="display: flex; gap: 0.5rem;">
                                        <button class="btn btn-secondary btn-sm" onclick="openEditModal({{ $p->id }}, '{{ addslashes($p->nama_paket) }}', '{{ $p->jenis_paket }}', {{ $p->harga_per_satuan }})">
                                            ✏️ Edit
                                        </button>
                                        <form action="{{ route('paket.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus paket ini? Semua transaksi terkait akan ikut terhapus secara cascade!')">
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

    <!-- Right Column: Add Package Form -->
    <div class="card">
        <h3 style="margin-bottom: 1.5rem;">Tambah Paket Baru</h3>
        
        <form action="{{ route('paket.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nama_paket" class="form-label">Nama Paket</label>
                <input type="text" name="nama_paket" id="nama_paket" class="form-control" required placeholder="Contoh: Paket Cuci Kering">
            </div>

            <div class="form-group">
                <label for="jenis_paket" class="form-label">Jenis Paket</label>
                <select name="jenis_paket" id="jenis_paket" class="form-control" required>
                    <option value="kiloan">Kiloan (/Kg)</option>
                    <option value="satuan">Satuan (/Pcs)</option>
                </select>
            </div>

            <div class="form-group">
                <label for="harga_per_satuan" class="form-label">Harga per Satuan (Rp)</label>
                <input type="number" name="harga_per_satuan" id="harga_per_satuan" class="form-control" required min="0" placeholder="Contoh: 7000">
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">
                Simpan Paket 💾
            </button>
        </form>
    </div>
</div>

<!-- Modal Edit Paket -->
<div id="editModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 100; align-items: center; justify-content: center; backdrop-filter: blur(8px);">
    <div class="card" style="width: 100%; max-width: 500px; margin: 1.5rem; position: relative;">
        <h3 style="margin-bottom: 1.5rem;">Edit Paket Laundry</h3>
        
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="edit_nama" class="form-label">Nama Paket</label>
                <input type="text" name="nama_paket" id="edit_nama" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="edit_jenis" class="form-label">Jenis Paket</label>
                <select name="jenis_paket" id="edit_jenis" class="form-control" required>
                    <option value="kiloan">Kiloan (/Kg)</option>
                    <option value="satuan">Satuan (/Pcs)</option>
                </select>
            </div>

            <div class="form-group">
                <label for="edit_harga" class="form-label">Harga per Satuan (Rp)</label>
                <input type="number" name="harga_per_satuan" id="edit_harga" class="form-control" required min="0">
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                <button type="button" class="btn btn-secondary" onclick="closeEditModal()" style="flex: 1;">Batal</button>
                <button type="submit" class="btn btn-primary" style="flex: 1;">Update Paket 💾</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(id, nama, jenis, harga) {
        const modal = document.getElementById('editModal');
        const form = document.getElementById('editForm');
        
        // Set action URL dynamically
        form.action = `/paket/${id}`;
        
        // Populate fields
        document.getElementById('edit_nama').value = nama;
        document.getElementById('edit_jenis').value = jenis;
        document.getElementById('edit_harga').value = harga;
        
        // Show modal with flex
        modal.style.display = 'flex';
    }

    function closeEditModal() {
        document.getElementById('editModal').style.display = 'none';
    }

    // Close when clicking outside of card content
    window.onclick = function(event) {
        const modal = document.getElementById('editModal');
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
</script>
@endsection
