<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - Sistem ISO</title>
<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/login.css">
<link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>📋</text></svg>">
</head>
<body>

<!-- Dark Mode Toggle -->
<button class="theme-toggle-login" aria-label="Toggle dark mode">🌙</button>

<div class="login-wrapper">
    <!-- LEFT SIDE - FORM -->
    <div class="login-form">
        <!-- Logo -->
        <div class="logo">ISO</div>
        
        <!-- Title -->
        <h1>Selamat Datang! 👋</h1>
        <p class="subtitle">Silakan login untuk mengakses Sistem ISO</p>
        
        <!-- Login Form -->
        <form method="POST" action="<?= BASE_URL_INDEX ?>?controller=Auth&action=auth">
            
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required placeholder="Masukkan username">
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required placeholder="Masukkan password">
            </div>
            
            <div class="form-options">
                <label>
                    <input type="checkbox" name="remember">
                    Ingat saya
                </label>
                <a href="#">Lupa password?</a>
            </div>
            
            <button type="submit" class="btn-login">
                Login
            </button>
            
            <div class="divider">atau</div>
            
            <p class="register-link">
                Belum punya akun? <a href="<?= BASE_URL_INDEX ?>?controller=Auth&action=register">Daftar</a>
            </p>
        </form>
    </div>
    
    <!-- RIGHT SIDE - INFO -->
    <div class="login-info">
        <div>
            <h2 class="info-title">Sistem Manajemen ISO</h2>
            <p class="info-subtitle">Platform terintegrasi untuk mengelola dokumen dan proses ISO dengan mudah dan efisien.</p>
            
            <ul class="features">
                <li>Manajemen Dokumen Digital</li>
                <li>Workflow Approval Otomatis</li>
                <li>Real-time Document Tracking</li>
                <li>AI-Powered Assistant</li>
                <li>Dashboard Analytics</li>
            </ul>
        </div>
    </div>
</div>

<script src="<?= BASE_URL ?>assets/js/main.js"></script>

</body>
</html>
