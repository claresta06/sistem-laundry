<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Sistem Pelayanan Laundry</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="app-container">
        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <div class="brand">
                <span>✨</span> LaundryGlow
            </div>
            
            <nav class="sidebar-nav">
                <a href="{{ route('dashboard') }}" class="nav-link {{ Route::is('dashboard') ? 'active' : '' }}">
                    <span>📊</span> Dashboard
                </a>
                <a href="{{ route('pelanggan.index') }}" class="nav-link {{ Route::is('pelanggan.*') ? 'active' : '' }}">
                    <span>👥</span> Pelanggan
                </a>
                <a href="{{ route('paket.index') }}" class="nav-link {{ Route::is('paket.*') ? 'active' : '' }}">
                    <span>🧺</span> Paket Laundry
                </a>
                <a href="{{ route('transaksi.index') }}" class="nav-link {{ Route::is('transaksi.*') ? 'active' : '' }}">
                    <span>🧾</span> Transaksi Laundry
                </a>
                <a href="{{ route('users.index') }}" class="nav-link {{ Route::is('users.*') ? 'active' : '' }}">
                    <span>🔐</span> Users
                </a>
            </nav>

            <div class="sidebar-footer">
                @auth
                    <div class="user-profile">
                        <div class="user-avatar">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>
                        <div class="user-details">
                            <span class="user-name">{{ Auth::user()->name }}</span>
                            <span class="user-role badge-role-{{ Auth::user()->role }}">{{ Auth::user()->role }}</span>
                        </div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-logout">
                            <span>🚪</span> Keluar
                        </button>
                    </form>
                @endauth
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="main-content">
            <!-- Alert Notification -->
            @if(session('success'))
                <div class="alert alert-success">
                    <span>✅</span> {{ session('success') }}
                </div>
            @endif

            <!-- Content Slot -->
            @yield('content')
        </main>
    </div>
</body>
</html>
