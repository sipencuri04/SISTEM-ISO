<?php
$pageTitle = 'Dashboard MR';
include BASE_PATH . '/app/views/mr/layout/header.php';
include BASE_PATH . '/app/views/mr/layout/sidebar.php';
?>

<div class="content">
    <h2>📊 Dashboard MR</h2>
    <p>Ringkasan review dokumen ISO</p>

    <div class="grid grid-3">
        <div class="card yellow">
            <h3>Menunggu Review</h3>
            <p><?= $pending ?? 0 ?></p>
        </div>
        <div class="card blue">
            <h3>Direview</h3>
            <p><?= $reviewed ?? 0 ?></p>
        </div>
        <div class="card green">
            <h3>Diteruskan ke GM</h3>
            <p><?= $toGm ?? 0 ?></p>
        </div>
    </div>
</div>

<?php include BASE_PATH . '/app/views/mr/layout/footer.php'; ?>
