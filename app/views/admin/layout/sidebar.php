<?php
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: " . BASE_URL . "?controller=Auth&action=login");
    exit;
}
?>
<style>
:root {
    --green: #22c55e;
    --green-soft: #dcfce7;
    --bg: #ffffff;
    --text: #111827;
    --muted: #6b7280;
    --border: #e5e7eb;
}

body {
    background: #f1f5f9;
}

.sidebar {
    width: 260px;
    height: calc(100vh - 40px);
    background: var(--bg);
    border-radius: 16px;
    margin: 20px;
    padding: 20px 16px;
    position: fixed;
    top: 0;
    left: 0;
    box-shadow: 0 10px 30px rgba(0,0,0,.06);
    display: flex;
    flex-direction: column;
}

.brand {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 20px;
    font-weight: bold;
    margin-bottom: 25px;
}

.brand .logo {
    width: 36px;
    height: 36px;
    background: var(--green);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-weight: bold;
}

.menu-title {
    font-size: 11px;
    text-transform: uppercase;
    color: var(--muted);
    margin: 18px 12px 8px;
}

.menu a {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 12px;
    border-radius: 10px;
    color: var(--text);
    text-decoration: none;
    font-size: 14px;
    transition: .2s;
}

.menu a:hover {
    background: var(--green-soft);
}

.menu a.active {
    background: var(--green-soft);
    color: var(--green);
    font-weight: 600;
}

.menu .icon {
    width: 20px;
    text-align: center;
}

.profile {
    margin-top: auto;
    padding-top: 15px;
    border-top: 1px solid var(--border);
    display: flex;
    align-items: center;
    gap: 10px;
}

.profile img {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    object-fit: cover;
}

.profile .name {
    font-size: 14px;
    font-weight: 600;
}

.profile .role {
    font-size: 12px;
    color: var(--muted);
}

.content {
    margin-left: 320px;
    padding: 30px;
}
</style>
<div class="sidebar">

    <!-- BRAND -->
    <div class="brand">
        <div class="logo">ISO</div>
        ISO HR
    </div>

    <!-- MENU -->
<div class="menu">
    <div class="menu-title">Menu</div>

    <a href="<?= BASE_URL ?>?controller=Dashboard&action=index" class="active">
        <span class="icon">🏠</span> Dashboard
    </a>

    <a href="<?= BASE_URL ?>?controller=User&action=userIndex">
        <span class="icon">👤</span> Manajemen User
    </a>

    <div class="menu-title">Dokumen</div>

    <!-- 🔥 APPROVAL ADMIN ISO -->
    <a href="<?= BASE_URL ?>?controller=Admin&action=index">
        <span class="icon">✅</span> Approval Dokumen
    </a>

    <a href="<?= BASE_URL ?>?controller=Document&action=index">
        <span class="icon">📄</span> Semua Dokumen
    </a>

    <div class="menu-title">Monitoring</div>

    <a href="<?= BASE_URL ?>?controller=Monitoring&action=index">
        <span class="icon">📊</span> Monitoring
    </a>

    <a href="<?= BASE_URL ?>?controller=Report&action=index">
        <span class="icon">📑</span> Laporan
    </a>

    <div class="menu-title">System</div>

    <a href="<?= BASE_URL ?>?controller=Auth&action=logout"
       onclick="return confirm('Yakin ingin logout?')">
        <span class="icon">🚪</span> Logout
    </a>
</div>

    <!-- PROFILE -->
    <div class="profile">
        <img src="https://i.pravatar.cc/100" alt="User">
        <div>
            <div class="name"><?= $_SESSION['user']['nama']; ?></div>
            <div class="role">Admin</div>
        </div>
    </div>
</div>
