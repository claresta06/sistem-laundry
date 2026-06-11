<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Pelayanan Laundry</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="auth-body">
    <div class="auth-wrapper">
        <div class="card auth-card">
            <div class="auth-header">
                <div class="auth-logo">✨ LaundryGlow</div>
                <p class="auth-subtitle">Silakan login untuk mengelola sistem laundry</p>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    <span>✅</span> {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email" class="form-label">Alamat Email</label>
                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus placeholder="nama@email.com">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Kata Sandi</label>
                    <input type="password" name="password" id="password" class="form-control" required placeholder="••••••••">
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">
                    Masuk ke Dashboard 🚪
                </button>
            </form>

            <div class="text-center mt-4">
                <p style="color: var(--text-secondary); font-size: 0.9rem;">
                    Belum punya akun? <a href="{{ route('register') }}" class="link-auth">Daftar sekarang</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
