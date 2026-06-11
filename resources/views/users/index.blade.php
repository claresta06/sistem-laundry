@extends('layouts.app')

@section('title', 'Manajemen Users')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Manajemen Users 🔐</h1>
        <p class="page-subtitle">Kelola data pengguna sistem laundry Anda.</p>
    </div>
</div>

{{-- Alert Error --}}
@if(session('error'))
    <div class="alert alert-danger">
        <span>⚠️</span> {{ session('error') }}
    </div>
@endif

<div class="grid-2col">
    <!-- Left Column: User List Table -->
    <div class="card">
        <h3 style="margin-bottom: 1.5rem;">Daftar Users</h3>
        
        <div class="table-container">
            @if($users->isEmpty())
                <div class="text-center" style="padding: 2rem; color: var(--text-secondary);">
                    Belum ada user terdaftar.
                </div>
            @else
                <table>
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                                        <div class="user-avatar-sm">
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        </div>
                                        <span style="font-weight: 600; color: #fff;">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="badge badge-role-{{ $user->role }}">{{ $user->role }}</span>
                                </td>
                                <td>
                                    <div style="display: flex; gap: 0.5rem;">
                                        <button class="btn btn-secondary btn-sm" onclick="openEditModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ addslashes($user->email) }}', '{{ $user->role }}')">
                                            ✏️ Edit
                                        </button>
                                        @if($user->id !== Auth::id())
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    🗑️ Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <!-- Right Column: Add User Form -->
    <div class="card">
        <h3 style="margin-bottom: 1.5rem;">Tambah User</h3>
        
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name" class="form-label">Nama Lengkap</label>
                <input type="text" name="name" id="name" class="form-control" required placeholder="Masukkan nama lengkap" value="{{ old('name') }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" required placeholder="contoh@email.com" value="{{ old('email') }}">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required placeholder="Minimal 6 karakter">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="role" class="form-label">Role</label>
                <select name="role" id="role" class="form-control" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="pelanggan" {{ old('role') == 'pelanggan' ? 'selected' : '' }}>Pelanggan</option>
                </select>
                @error('role')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">
                Simpan User 💾
            </button>
        </form>
    </div>
</div>

<!-- Modal Edit User -->
<div id="editModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 100; align-items: center; justify-content: center; backdrop-filter: blur(8px);">
    <div class="card" style="width: 100%; max-width: 500px; margin: 1.5rem; position: relative;">
        <h3 style="margin-bottom: 1.5rem;">Edit Data User</h3>
        
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="edit_name" class="form-label">Nama Lengkap</label>
                <input type="text" name="name" id="edit_name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="edit_email" class="form-label">Email</label>
                <input type="email" name="email" id="edit_email" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="edit_password" class="form-label">Password Baru <span style="color: var(--text-secondary); font-size: 0.75rem; text-transform: none; letter-spacing: normal;">(kosongkan jika tidak ingin mengubah)</span></label>
                <input type="password" name="password" id="edit_password" class="form-control" placeholder="Kosongkan jika tidak diubah">
            </div>

            <div class="form-group">
                <label for="edit_role" class="form-label">Role</label>
                <select name="role" id="edit_role" class="form-control" required>
                    <option value="admin">Admin</option>
                    <option value="pelanggan">Pelanggan</option>
                </select>
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                <button type="button" class="btn btn-secondary" onclick="closeEditModal()" style="flex: 1;">Batal</button>
                <button type="submit" class="btn btn-primary" style="flex: 1;">Update Data 💾</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(id, name, email, role) {
        const modal = document.getElementById('editModal');
        const form = document.getElementById('editForm');
        
        // Set action URL dynamically
        form.action = `/users/${id}`;
        
        // Populate fields
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_email').value = email;
        document.getElementById('edit_role').value = role;
        document.getElementById('edit_password').value = '';
        
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
