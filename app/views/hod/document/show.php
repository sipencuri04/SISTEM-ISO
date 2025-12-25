<?php
include BASE_PATH . '/app/views/hod/layout/header.php';
include BASE_PATH . '/app/views/hod/layout/sidebar.php';
?>

<style>
.content{
    padding:24px;
    background:#f1f5f9;
    min-height:100vh;
    font-family:system-ui, -apple-system, BlinkMacSystemFont;
}

.card{
    background:#ffffff;
    padding:24px;
    border-radius:16px;
    box-shadow:0 10px 25px rgba(0,0,0,.06);
    max-width:800px;
}

.card h2{
    margin-bottom:20px;
    font-size:20px;
}

/* ===== INFO TABLE ===== */
.info-table{
    width:100%;
    border-collapse:collapse;
    font-size:14px;
}

.info-table td{
    padding:10px 8px;
    vertical-align:top;
}

.info-table td:first-child{
    width:220px;
    color:#475569;
    font-weight:600;
}

/* ===== BADGE ===== */
.badge{
    padding:4px 12px;
    border-radius:999px;
    font-size:12px;
    font-weight:600;
}

.pending{background:#fef3c7;color:#92400e;}
.approved{background:#dcfce7;color:#166534;}
.rejected{background:#fee2e2;color:#991b1b;}

/* ===== FILE ===== */
.file-link{
    color:#2563eb;
    font-weight:600;
    text-decoration:none;
}

/* ===== ACTION ===== */
.actions{
    margin-top:24px;
    display:flex;
    gap:12px;
}

.btn{
    padding:10px 18px;
    border-radius:10px;
    font-size:14px;
    font-weight:600;
    text-decoration:none;
    cursor:pointer;
}

.btn-approve{
    background:#22c55e;
    color:#ffffff;
}

.btn-reject{
    background:#dc2626;
    color:#ffffff;
}

.btn-back{
    background:#e5e7eb;
    color:#334155;
}
</style>

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
            <a href="<?= BASE_URL ?>?controller=Hod&action=approve&id=<?= $document['id']; ?>"
               onclick="return confirm('Setujui dokumen ini?')"
               class="btn btn-approve">
               ✔ Approve
            </a>

            <a href="<?= BASE_URL ?>?controller=Hod&action=reject&id=<?= $document['id']; ?>"
               onclick="return confirm('Tolak dokumen ini?')"
               class="btn btn-reject">
               ✖ Reject
            </a>

            <a href="<?= BASE_URL ?>?controller=Hod&action=index"
               class="btn btn-back">
               ← Kembali
            </a>
        </div>

    </div>
</div>
