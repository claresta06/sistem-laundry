@extends('layouts.app')

@section('title', 'Manajemen Pelanggan')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Manajemen Pelanggan 👥</h1>
        <p class="page-subtitle">Kelola data pelanggan laundry Anda secara efisien.</p>
    </div>
</div>

<div class="grid-2col">
    <!-- Left Column: Customer List Table -->
    <div class="card">
        <h3 style="margin-bottom: 1.5rem;">Daftar Pelanggan</h3>
        
        <div class="table-container">
            @if($pelanggans->isEmpty())
                <div class="text-center" style="padding: 2rem; color: var(--text-secondary);">
                    Belum ada pelanggan terdaftar.
                </div>
            @else
                <table>
                    <thead>
                        <tr>
                            <th>Nama Pelanggan</th>
                            <th>No. Telepon</th>
                            <th>Alamat</th>
                            <th style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pelanggans as $p)
                            <tr>
                                <td style="font-weight: 600; color: #fff;">{{ $p->nama_pelanggan }}</td>
                                <td>{{ $p->nomor_telepon }}</td>
                                <td>{{ $p->alamat }}</td>
                                <td>
                                    <div style="display: flex; gap: 0.5rem;">
                                        <button class="btn btn-secondary btn-sm" onclick="openEditModal({{ $p->id }}, '{{ addslashes($p->nama_pelanggan) }}', '{{ addslashes($p->nomor_telepon) }}', '{{ addslashes($p->alamat) }}')">
                                            ✏️ Edit
                                        </button>
                                        <form action="{{ route('pelanggan.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pelanggan ini? Semua transaksi terkait akan ikut terhapus secara cascade!')">
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

    <!-- Right Column: Add Customer Form -->
    <div class="card">
        <h3 style="margin-bottom: 1.5rem;">Tambah Pelanggan</h3>
        
        <form action="{{ route('pelanggan.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nama_pelanggan" class="form-label">Nama Pelanggan</label>
                <input type="text" name="nama_pelanggan" id="nama_pelanggan" class="form-control" required placeholder="Masukkan nama pelanggan">
            </div>

            <div class="form-group">
                <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                <input type="text" name="nomor_telepon" id="nomor_telepon" class="form-control" required placeholder="Contoh: 08123456789">
            </div>

            <div class="form-group">
                <label for="alamat" class="form-label">Alamat Lengkap</label>
                <textarea name="alamat" id="alamat" rows="3" class="form-control" required placeholder="Masukkan alamat lengkap pelanggan"></textarea>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">
                Simpan Pelanggan 💾
            </button>
        </form>
    </div>
</div>

<!-- Modal Edit Pelanggan -->
<div id="editModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 100; align-items: center; justify-content: center; backdrop-filter: blur(8px);">
    <div class="card" style="width: 100%; max-width: 500px; margin: 1.5rem; position: relative;">
        <h3 style="margin-bottom: 1.5rem;">Edit Data Pelanggan</h3>
        
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="edit_nama" class="form-label">Nama Pelanggan</label>
                <input type="text" name="nama_pelanggan" id="edit_nama" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="edit_telp" class="form-label">Nomor Telepon</label>
                <input type="text" name="nomor_telepon" id="edit_telp" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="edit_alamat" class="form-label">Alamat Lengkap</label>
                <textarea name="alamat" id="edit_alamat" rows="3" class="form-control" required></textarea>
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                <button type="button" class="btn btn-secondary" onclick="closeEditModal()" style="flex: 1;">Batal</button>
                <button type="submit" class="btn btn-primary" style="flex: 1;">Update Data 💾</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(id, nama, telp, alamat) {
        const modal = document.getElementById('editModal');
        const form = document.getElementById('editForm');
        
        // Set action URL dynamically
        form.action = `/pelanggan/${id}`;
        
        // Populate fields
        document.getElementById('edit_nama').value = nama;
        document.getElementById('edit_telp').value = telp;
        document.getElementById('edit_alamat').value = alamat;
        
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
