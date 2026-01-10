<?php
// 🔐 PROTEKSI LOGIN
if (!isset($_SESSION['user'])) {
    header("Location: " . BASE_URL . "?controller=Auth&action=login");
    exit;
}

$pageTitle = 'Daftar Dokumen';
include BASE_PATH . '/app/views/pic/layout/header.php';
include BASE_PATH . '/app/views/pic/layout/sidebar.php';
?>

<div class="content">
    <div class="table-container">
        <div class="header" style="display:flex;justify-content:space-between;align-items:center;padding:24px 24px 0;">
            <div>
                <h2 style="margin:0 0 4px 0;">📄 Daftar Pengajuan Dokumen</h2>
                <p style="margin:0;color:var(--text-secondary);font-size:14px;">Kelola semua pengajuan dokumen Anda</p>
            </div>
            <a href="<?= BASE_URL_INDEX ?>?controller=Document&action=create" class="btn btn-primary">
                ➕ Ajukan Dokumen
            </a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Judul Dokumen Baru</th>
                    <th>Judul Lama</th>
                    <th>Jenis</th>
                    <th>Pengajuan</th>
                    <th>Revisi</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>
            </thead>

            <tbody>
            <?php if (empty($documents)): ?>
                <tr>
                    <td colspan="8" style="text-align:center;color:var(--text-secondary);font-style:italic;padding:40px;">
                        Belum ada pengajuan dokumen
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($documents as $doc): ?>
                <tr>
                    <td><strong><?= htmlspecialchars($doc['kode_dokumen']); ?></strong></td>

                    <td><?= htmlspecialchars($doc['judul_baru'] ?? $doc['nama_dokumen']); ?></td>

                    <td>
                        <?= !empty($doc['judul_lama']) 
                            ? htmlspecialchars($doc['judul_lama']) 
                            : '<span style="color:var(--text-secondary)">-</span>' ?>
                    </td>

                    <td><?= htmlspecialchars($doc['jenis_dokumen']); ?></td>

                    <td><strong><?= strtoupper($doc['jenis_pengajuan']); ?></strong></td>

                    <td><?= htmlspecialchars($doc['versi']); ?></td>

                    <td>
                        <?php
                        if (str_contains($doc['status'], 'Menunggu')) {
                            echo '<span class="badge warning">'.$doc['status'].'</span>';
                        } elseif ($doc['status'] === 'Disetujui') {
                            echo '<span class="badge success">Disetujui</span>';
                        } else {
                            echo '<span class="badge danger">'.$doc['status'].'</span>';
                        }
                        ?>
                    </td>

                    <td><?= date('d M Y', strtotime($doc['created_at'])); ?></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>

    </div>
</div>

<?php include BASE_PATH . '/app/views/pic/layout/footer.php'; ?>
