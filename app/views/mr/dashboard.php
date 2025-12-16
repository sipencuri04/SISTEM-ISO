<?php
include BASE_PATH . '/app/views/mr/layout/header.php';
include BASE_PATH . '/app/views/mr/layout/sidebar.php';
?>

<div class="content">
    <h2>Dashboard mr</h2>
    <p>Selamat datang, <strong><?= $_SESSION['user']['nama']; ?></strong></p>
</div>

<?php include BASE_PATH . '/app/views/mr/layout/footer.php'; ?>
