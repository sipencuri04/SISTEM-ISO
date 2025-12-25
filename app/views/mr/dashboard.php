<?php
include BASE_PATH . '/app/views/mr/layout/header.php';
include BASE_PATH . '/app/views/mr/layout/sidebar.php';
?>

<style>
.content{padding:24px;background:#f1f5f9;min-height:100vh;font-family:system-ui}
.grid{display:grid;grid-template-columns:repeat(3,1fr);gap:16px}
.card{background:#fff;padding:20px;border-radius:16px;
box-shadow:0 10px 25px rgba(0,0,0,.06)}
.card h3{font-size:14px;color:#64748b}
.card p{font-size:28px;font-weight:700}
</style>

<div class="content">
<h2>📊 Dashboard MR</h2>

<div class="grid">
    <div class="card">
        <h3>Menunggu Review</h3>
        <p><?= $pending ?? 0 ?></p>
    </div>
    <div class="card">
        <h3>Direview</h3>
        <p><?= $reviewed ?? 0 ?></p>
    </div>
    <div class="card">
        <h3>Diteruskan ke GM</h3>
        <p><?= $toGm ?? 0 ?></p>
    </div>
</div>
</div>
