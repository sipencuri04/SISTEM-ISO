<?php
include BASE_PATH . '/app/views/pic/layout/header.php';
include BASE_PATH . '/app/views/pic/layout/sidebar.php';
?>

<div class="content">
    <h2>Dashboard PIC</h2>
    <p>Selamat datang, <strong><?= $_SESSION['user']['nama']; ?></strong></p>
</div>

<?php include BASE_PATH . '/app/views/pic/layout/footer.php'; ?>
