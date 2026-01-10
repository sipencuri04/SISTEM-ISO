<?php
include BASE_PATH . '/app/views/hod/layout/header.php';
include BASE_PATH . '/app/views/hod/layout/sidebar.php';
?>

<div class="content">
    <div class="card">
        <h2>📄 Detail Dokumen (Approval HOD)</h2>

        <table class="info-table">
            <tr>
                <td>Kode Dokumen</td>
                <td><?= htmlspecialchars($document['kode_dokumen']); ?></td>
            </tr>
            <tr>
                <td>Nama Dokumen</td>
                <td><?= htmlspecialchars($document['nama_dokumen']); ?></td>
            </tr>
            <tr>
                <td>Departemen</td>
                <td><?= htmlspecialchars($document['departemen']); ?></td>
            </tr>
            <tr>
                <td>Status</td>
                <td>
                    <span class="badge
                        <?= $document['status']=='approved'?'approved':($document['status']=='rejected'?'rejected':'pending'); ?>">
                        <?= strtoupper($document['status']); ?>
                    </span>
                </td>
            </tr>
            <tr>
                <td>Alasan Pengajuan</td>
                <td><?= nl2br(htmlspecialchars($document['alasan'])); ?></td>
            </tr>

            <?php if (!empty($document['deskripsi_perubahan'])): ?>
            <tr>
                <td>Deskripsi Perubahan</td>
                <td><?= nl2br(htmlspecialchars($document['deskripsi_perubahan'])); ?></td>
            </tr>
            <?php endif; ?>

            <tr>
                <td>File Dokumen</td>
                <td>
                    <a class="file-link"
                       href="<?= BASE_URL . $document['file_path']; ?>"
                       target="_blank">
                        Download / Lihat Dokumen
                    </a>
                </td>
            </tr>
        </table>

        <!-- ===== FILE PREVIEW ===== -->
        <div style="margin-top:24px;">
            <h3>📎 Preview Dokumen</h3>
            <?php 
            $baseUrl = str_replace('/index.php', '', BASE_URL);
            $fileUrl = $baseUrl . '/' . $document['file_path'];
            
            // Cek fisik
            $localAbsPath = BASE_PATH . '/public/' . $document['file_path'];
            $isFileExists = file_exists($localAbsPath);

            $ext = strtolower(pathinfo($document['file_path'], PATHINFO_EXTENSION));
            
            if (!$isFileExists): ?>
                <div class="alert alert-danger" style="background:#fee2e2; color:#991b1b; padding:15px; border-radius:12px; border:1px solid #fca5a5;">
                    ⚠️ <b>File fisik tidak ditemukan di server.</b>
                </div>
            <?php elseif ($ext === 'pdf'): ?>
                <iframe src="<?= $fileUrl ?>" width="100%" height="600px" style="border:1px solid #e2e8f0; border-radius:12px;"></iframe>
                <div style="margin-top:10px; text-align:right;">
                    <a class="file-link" href="<?= $fileUrl; ?>" target="_blank">⬇ Download PDF</a>
                </div>
            <?php else: ?>
                 <a class="file-link" href="<?= $fileUrl; ?>" target="_blank">Download / Lihat Dokumen</a>
            <?php endif; ?>
        </div>

        <div class="actions">
            <a href="<?= BASE_URL_INDEX ?>?controller=Hod&action=approve&id=<?= $document['id']; ?>"
               onclick="return confirm('Setujui dokumen ini?')"
               class="btn btn-approve">
               ✔ Approve
            </a>

            <a href="<?= BASE_URL_INDEX ?>?controller=Hod&action=reject&id=<?= $document['id']; ?>"
               onclick="return confirm('Tolak dokumen ini?')"
               class="btn btn-reject">
               ✖ Reject
            </a>

            <a href="<?= BASE_URL_INDEX ?>?controller=Hod&action=index"
               class="btn btn-back">
               ← Kembali
            </a>
        </div>

    </div>
</div>
