<?php
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'pic') {
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
        <a href="<?= BASE_URL_INDEX ?>?controller=Document&action=index"
           class="<?= ($currentController == 'Document' && $currentAction == 'index') ? 'active' : '' ?>">
            <span class="icon">📄</span> Dokumen Saya
        </a>
        
        <a href="<?= BASE_URL_INDEX ?>?controller=Document&action=create"
           class="<?= ($currentController == 'Document' && $currentAction == 'create') ? 'active' : '' ?>">
            <span class="icon">➕</span> Pengajuan Dokumen
        </a>
        
        <a href="<?= BASE_URL_INDEX ?>?controller=Pic&action=archive"
           class="<?= ($currentController == 'Pic' && $currentAction == 'archive') ? 'active' : '' ?>">
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
        <img src="https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['user']['nama']) ?>&background=22c55e&color=fff" alt="User">
        <div class="info">
            <div class="name"><?= $_SESSION['user']['nama']; ?></div>
            <div class="role">Person In Charge</div>
        </div>
    </div>
</div>
