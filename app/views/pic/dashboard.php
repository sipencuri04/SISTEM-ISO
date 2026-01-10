<?php
$pageTitle = 'Dashboard PIC';
include BASE_PATH . '/app/views/pic/layout/header.php';
include BASE_PATH . '/app/views/pic/layout/sidebar.php';
?>

<div class="content">
    <h2>📊 Dashboard PIC</h2>
    <p>Selamat datang, <strong><?= $_SESSION['user']['nama']; ?></strong></p>

    <div class="grid grid-4">
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

<?php include BASE_PATH . '/app/views/pic/layout/footer.php'; ?>
