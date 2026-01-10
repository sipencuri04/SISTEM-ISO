<?php
$pageTitle = 'Dashboard HOD';
include BASE_PATH . '/app/views/hod/layout/header.php';
include BASE_PATH . '/app/views/hod/layout/sidebar.php';
?>

<div class="content">
    <h2>📊 Dashboard HOD</h2>
    <p>Departemen: <strong><?= $_SESSION['user']['departemen']; ?></strong></p>

    <div class="grid grid-3">
        <div class="card blue">
            <h3>Pengajuan Masuk</h3>
            <p><?= $total ?? 0 ?></p>
        </div>
        <div class="card yellow">
            <h3>Menunggu Approval</h3>
            <p><?= $pending ?? 0 ?></p>
        </div>
        <div class="card green">
            <h3>Sudah Diproses</h3>
            <p><?= $approved ?? 0 ?></p>
        </div>
    </div>
</div>

<?php include BASE_PATH . '/app/views/hod/layout/footer.php'; ?>
