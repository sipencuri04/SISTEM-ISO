<?php
// 🔐 PROTEKSI LOGIN WAJIB DI PALING ATAS
if (!isset($_SESSION['user'])) {
    header("Location: " . BASE_URL . "?controller=Auth&action=login");
    exit;
}

// BARU INCLUDE LAYOUT
include BASE_PATH . '/app/views/pic/layout/header.php';
include BASE_PATH . '/app/views/pic/layout/sidebar.php';
?>

<div class="content">
    <h2>Daftar Pengajuan Dokumen Saya</h2>

    <a href="<?= BASE_URL ?>?controller=Document&action=create"
       style="display:inline-block;margin-bottom:16px;
              background:#22c55e;color:#fff;padding:10px 16px;
              border-radius:8px;text-decoration:none">
        + Ajukan Dokumen
    </a>

    <table width="100%" cellpadding="10" cellspacing="0" border="1">
        <tr style="background:#f3f4f6">
            <th>Kode</th>
            <th>Nama Dokumen</th>
            <th>Jenis</th>
            <th>Pengajuan</th>
            <th>Status</th>
            <th>Tanggal</th>
        </tr>

        <?php if (empty($documents)): ?>
            <tr>
                <td colspan="6" align="center">Belum ada pengajuan</td>
            </tr>
        <?php else: ?>
            <?php foreach ($documents as $doc): ?>
            <tr>
                <td><?= htmlspecialchars($doc['kode_dokumen']); ?></td>
                <td><?= htmlspecialchars($doc['nama_dokumen']); ?></td>
                <td><?= htmlspecialchars($doc['jenis_dokumen']); ?></td>
                <td><?= strtoupper($doc['jenis_pengajuan']); ?></td>
                <td><?= htmlspecialchars($doc['status']); ?></td>
                <td><?= date('d-m-Y', strtotime($doc['created_at'])); ?></td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
</div>
