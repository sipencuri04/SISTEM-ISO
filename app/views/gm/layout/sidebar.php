<?php
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'gm') {
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

        <div class="menu-title">Dokumen</div>
        <a href="<?= BASE_URL_INDEX ?>?controller=Gm&action=index"
           class="<?= ($currentController == 'Gm') ? 'active' : '' ?>">
            <span class="icon">✅</span> Pengesahan GM
        </a>

        <div class="menu-title">System</div>
        <a href="<?= BASE_URL_INDEX ?>?controller=Auth&action=logout"
           onclick="return confirm('Yakin ingin logout?')">
            <span class="icon">🚪</span> Logout
        </a>
    </div>

    <!-- PROFILE -->
    <div class="profile">
        <img src="https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['user']['nama']) ?>&background=3b82f6&color=fff" alt="User">
        <div class="info">
            <div class="name"><?= $_SESSION['user']['nama']; ?></div>
            <div class="role">General Manager</div>
        </div>
    </div>
</div>
