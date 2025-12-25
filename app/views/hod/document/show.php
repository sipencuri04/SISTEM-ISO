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
