<?php
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'hod') {
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
        <a href="<?= BASE_URL_INDEX ?>?controller=Hod&action=index"
           class="<?= ($currentController == 'Hod' && $currentAction == 'index') ? 'active' : '' ?>">
            <span class="icon">📝</span> Approval Dokumen
        </a>
        
        <a href="<?= BASE_URL_INDEX ?>?controller=Hod&action=archive"
           class="<?= ($currentController == 'Hod' && $currentAction == 'archive') ? 'active' : '' ?>">
            <span class="icon">📂</span> Arsip Disetujui
        </a>

        <div class="menu-title">System</div>
        <a href="<?= BASE_URL_INDEX ?>?controller=Auth&action=logout"
           onclick="return confirm('Yakin ingin logout?')">
            <span class="icon">🚪</span> Logout
        </a>
    </div>

    <!-- PROFILE -->
    <div class="profile">
        <img src="https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['user']['nama']) ?>&background=facc15&color=000" alt="User">
        <div class="info">
            <div class="name"><?= $_SESSION['user']['nama']; ?></div>
            <div class="role">Head of Department</div>
        </div>
    </div>
</div>
