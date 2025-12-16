<?php
include BASE_PATH . '/app/views/hod/layout/header.php';
include BASE_PATH . '/app/views/hod/layout/sidebar.php';
?>

<div class="content">
    <h2>Dashboard hod</h2>
    <p>Selamat datang, <strong><?= $_SESSION['user']['nama']; ?></strong></p>
</div>

<?php include BASE_PATH . '/app/views/hod/layout/footer.php'; ?>
