<?php
include BASE_PATH . '/app/views/gm/layout/header.php';
include BASE_PATH . '/app/views/gm/layout/sidebar.php';
?>

<div class="content">
    <h2>Dashboard gm</h2>
    <p>Selamat datang, <strong><?= $_SESSION['user']['nama']; ?></strong></p>
</div>

<?php include BASE_PATH . '/app/views/gm/layout/footer.php'; ?>
