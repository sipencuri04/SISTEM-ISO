<?php
$pageTitle = 'Arsip Dokumen';
include BASE_PATH . '/app/views/hod/layout/header.php';
include BASE_PATH . '/app/views/hod/layout/sidebar.php';
?>

<div class="content">
    <div style="margin-bottom:var(--spacing-lg);">
        <h2>📂 Arsip Dokumen Disetujui</h2>
        <p>Daftar dokumen departemen yang telah disahkan oleh General Manager (GM)</p>
    </div>

    <div class="table-container">
        <?php if (empty($documents)): ?>
            <div style="text-align:center; padding:60px 20px; color:var(--text-secondary);">
                <span style="font-size:48px; display:block; margin-bottom:16px;">📭</span>
                <p style="font-size:16px;">Belum ada dokumen yang disahkan saat ini.</p>
            </div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Judul Dokumen</th>
                        <th>Versi</th>
                        <th>Tanggal Sah</th>
                        <th style="text-align:right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($documents as $doc): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($doc['kode_dokumen']) ?></strong></td>
                            <td>
                                <div style="font-weight:600; color:var(--text-primary); margin-bottom:4px;">
                                    <?= htmlspecialchars($doc['judul_baru']) ?>
                                </div>
                                <div style="font-size:12px; color:var(--text-secondary);">
                                    <?= htmlspecialchars($doc['jenis_dokumen']) ?>
                                </div>
                            </td>
                            <td>
                                <span class="badge info">
                                    <?= htmlspecialchars($doc['versi']) ?>
                                </span>
                            </td>
                            <td><?= date('d M Y', strtotime($doc['updated_at'] ?? $doc['created_at'])) ?></td>
                            <td style="text-align:right;">
                                <?php
                                $baseUrl = rtrim(BASE_URL, '/index.php');
                                $fileUrl = $baseUrl . '/' . $doc['file_path'];
                                $localAbsPath = BASE_PATH . '/public/' . $doc['file_path'];
                                $fileExists = file_exists($localAbsPath);
                                ?>
                                
                                <?php if ($fileExists): ?>
                                    <a href="<?= $fileUrl ?>" target="_blank" class="btn btn-outline" style="margin-right:8px;">
                                        👁️ Lihat
                                    </a>
                                    <a href="<?= $fileUrl ?>" download class="btn btn-primary">
                                        ⬇️ Unduh
                                    </a>
                                <?php else: ?>
                                    <span class="badge danger">
                                        ⚠️ File Hilang
                                    </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<?php include BASE_PATH . '/app/views/hod/layout/footer.php'; ?>
