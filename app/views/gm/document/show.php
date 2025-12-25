<?php
include BASE_PATH . '/app/views/gm/layout/header.php';
include BASE_PATH . '/app/views/gm/layout/sidebar.php';
?>

<style>
.content{
    padding:24px;
    background:#f1f5f9;
    min-height:100vh;
    font-family:system-ui, -apple-system, BlinkMacSystemFont;
}

.card{
    background:#fff;
    padding:24px;
    border-radius:16px;
    box-shadow:0 10px 25px rgba(0,0,0,.06);
    max-width:900px;
}

.header{
    margin-bottom:20px;
}

.header h2{
    margin:0;
    font-size:20px;
}

.table{
    width:100%;
    border-collapse:collapse;
    font-size:14px;
}

.table td{
    padding:12px 10px;
    vertical-align:top;
}

.table tr td:first-child{
    width:220px;
    color:#475569;
    font-weight:600;
}

.section{
    margin-top:28px;
}

.badge{
    padding:4px 12px;
    border-radius:999px;
    font-size:12px;
    font-weight:600;
}

.wait{background:#fef3c7;color:#92400e;}
.ok{background:#dcfce7;color:#166534;}
.no{background:#fee2e2;color:#991b1b;}

.old{
    background:#fee2e2;
    color:#991b1b;
    padding:6px 10px;
    border-radius:8px;
    display:inline-block;
}

.new{
    background:#dcfce7;
    color:#166534;
    padding:6px 10px;
    border-radius:8px;
    display:inline-block;
}

.note{
    font-size:12px;
    color:#64748b;
    margin-top:4px;
}

.actions{
    margin-top:28px;
}

.actions a{
    text-decoration:none;
    font-weight:600;
    margin-right:16px;
}

.approve{color:#16a34a;}
.reject{color:#dc2626;}
.back{color:#2563eb;}
</style>

<div class="content">
    <div class="card">

        <div class="header">
            <h2>🏁 Detail Dokumen – Pengesahan GM</h2>
        </div>

        <!-- ================= INFORMASI DOKUMEN ================= -->
        <table class="table">
            <tr>
                <td>Kode Dokumen</td>
                <td><?= htmlspecialchars($document['kode_dokumen']); ?></td>
            </tr>

            <tr>
                <td>Judul Dokumen Lama</td>
                <td>
                    <?php if (!empty($document['judul_lama'])): ?>
                        <span class="old">
                            <?= htmlspecialchars($document['judul_lama']); ?>
                        </span>
                        <div class="note">Dokumen sebelum perubahan</div>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
            </tr>

            <tr>
                <td>Judul Dokumen Baru</td>
                <td>
                    <span class="new">
                        <?= htmlspecialchars($document['judul_baru'] ?? $document['nama_dokumen']); ?>
                    </span>
                    <div class="note">Dokumen setelah perubahan</div>
                </td>
            </tr>

            <tr>
                <td>Departemen</td>
                <td><?= htmlspecialchars($document['departemen']); ?></td>
            </tr>

            <tr>
                <td>Jenis Pengajuan</td>
                <td><?= strtoupper($document['jenis_pengajuan']); ?></td>
            </tr>

            <tr>
                <td>Revisi</td>
                <td><?= htmlspecialchars($document['versi']); ?></td>
            </tr>

            <tr>
                <td>Status</td>
                <td>
                    <?php
                    if (str_contains($document['status'], 'Menunggu')) {
                        echo '<span class="badge wait">'.$document['status'].'</span>';
                    } elseif ($document['status'] === 'Approved') {
                        echo '<span class="badge ok">Approved</span>';
                    } else {
                        echo '<span class="badge no">'.$document['status'].'</span>';
                    }
                    ?>
                </td>
            </tr>

            <tr>
                <td>Alasan / Uraian Perubahan</td>
                <td><?= nl2br(htmlspecialchars($document['alasan'])); ?></td>
            </tr>

            <?php if (!empty($document['deskripsi_perubahan'])): ?>
            <tr>
                <td>Deskripsi Perubahan</td>
                <td><?= nl2br(htmlspecialchars($document['deskripsi_perubahan'])); ?></td>
            </tr>
            <?php endif; ?>

            <?php if (!empty($document['dampak_perubahan'])): ?>
            <tr>
                <td>Dampak Perubahan</td>
                <td><?= nl2br(htmlspecialchars($document['dampak_perubahan'])); ?></td>
            </tr>
            <?php endif; ?>
        </table>

        <!-- ================= FILE DOKUMEN ================= -->
        <div class="section">
            <h3>📎 Dokumen Terlampir</h3>

            <?php
            // File berada di public/uploads
            $fileUrl = BASE_URL . '/public/' . $document['file_path'];
            $ext = strtolower(pathinfo($document['file_path'], PATHINFO_EXTENSION));
            ?>

            <?php if ($ext === 'pdf'): ?>
                <a href="<?= $fileUrl; ?>"
                   target="_blank"
                   class="back"
                   style="font-weight:600">
                    ⬇ Download Dokumen PDF
                </a>

                <div class="note">
                    Dokumen final yang akan disahkan oleh GM.
                </div>
            <?php else: ?>
                <p style="color:#dc2626">
                    ❌ Lampiran tidak valid. Sistem hanya menerima file PDF.
                </p>
            <?php endif; ?>
        </div>

        <!-- ================= AKSI ================= -->
        <div class="actions">
            <a class="approve"
               href="<?= BASE_URL ?>?controller=Gm&action=approve&id=<?= $document['id']; ?>"
               onclick="return confirm('Sahkan dokumen ini sebagai dokumen resmi perusahaan?')">
               ✔ Sahkan (Final)
            </a>

            <a class="reject"
               href="<?= BASE_URL ?>?controller=Gm&action=reject&id=<?= $document['id']; ?>"
               onclick="return confirm('Tolak dokumen ini?')">
               ✖ Tolak
            </a>

            <a class="back"
               href="<?= BASE_URL ?>?controller=Gm&action=index">
               ← Kembali
            </a>
        </div>

    </div>
</div>
