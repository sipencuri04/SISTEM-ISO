<?php
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: " . BASE_URL . "?controller=Auth&action=login");
    exit;
}

$currentController = $_GET['controller'] ?? 'Dashboard';
$currentAction = $_GET['action'] ?? 'index';
?>

<div class="sidebar">
    <!-- BRAND -->
    <div class="brand">
        <div class="logo">ISO</div>
        <span>Sistem ISO</span>
    </div>

    <!-- MENU -->
    <div class="menu">
        <div class="menu-title">Dashboard</div>
        <a href="<?= BASE_URL_INDEX ?>?controller=Dashboard&action=index" 
           class="<?= ($currentController == 'Dashboard') ? 'active' : '' ?>">
            <span class="icon">📊</span> Dashboard
        </a>

        <div class="menu-title">Manajemen Dokumen</div>
        <a href="<?= BASE_URL_INDEX ?>?controller=Admin&action=index"
           class="<?= ($currentController == 'Admin') ? 'active' : '' ?>">
            <span class="icon">📄</span> Validasi Dokumen
        </a>
        
        <a href="<?= BASE_URL_INDEX ?>?controller=History&action=index"
           class="<?= ($currentController == 'History') ? 'active' : '' ?>">
            <span class="icon">📜</span> History Dokumen
        </a>

        <div class="menu-title">Manajemen Pengguna</div>
        <a href="<?= BASE_URL_INDEX ?>?controller=User&action=index"
           class="<?= ($currentController == 'User') ? 'active' : '' ?>">
            <span class="icon">👥</span> Kelola User
        </a>

        <div class="menu-title">AI Tools</div>
        <a href="<?= BASE_URL_INDEX ?>?controller=AiChat&action=index"
           class="<?= ($currentController == 'AiChat') ? 'active' : '' ?>">
            <span class="icon">🤖</span> AI Chat
        </a>

        <div class="menu-title">System</div>
        <a href="<?= BASE_URL_INDEX ?>?controller=Auth&action=logout"
           onclick="return confirm('Yakin ingin logout?')">
            <span class="icon">🚪</span> Logout
        </a>
    </div>

    <!-- PROFILE -->
    <div class="profile">
        <img src="https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['user']['nama']) ?>&background=22c55e&color=fff" alt="User">
        <div class="info">
            <div class="name"><?= $_SESSION['user']['nama']; ?></div>
            <div class="role">Administrator</div>
        </div>
    </div>
</div>
