<?php
include BASE_PATH . '/app/views/pic/layout/header.php';
include BASE_PATH . '/app/views/pic/layout/sidebar.php';
?>

<style>
.content{padding:24px;background:#f1f5f9;min-height:100vh;font-family:system-ui}
.grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px}
.card{background:#fff;padding:20px;border-radius:16px;
box-shadow:0 10px 25px rgba(0,0,0,.06)}
.card h3{font-size:14px;color:#64748b;margin:0}
.card p{font-size:28px;font-weight:700;margin:8px 0 0}
.green{border-top:4px solid #22c55e}
.yellow{border-top:4px solid #facc15}
.red{border-top:4px solid #ef4444}
.blue{border-top:4px solid #3b82f6}
</style>

<div class="content">
<h2>📊 Dashboard PIC</h2>
<p>Selamat datang, <b><?= $_SESSION['user']['nama']; ?></b></p>

<div class="grid">
    <div class="card blue">
        <h3>Total Pengajuan</h3>
        <p><?= $total ?? 0 ?></p>
    </div>
    <div class="card yellow">
        <h3>Menunggu Approval</h3>
        <p><?= $pending ?? 0 ?></p>
    </div>
    <div class="card green">
        <h3>Disetujui</h3>
        <p><?= $approved ?? 0 ?></p>
    </div>
    <div class="card red">
        <h3>Ditolak</h3>
        <p><?= $rejected ?? 0 ?></p>
    </div>
</div>
</div>
