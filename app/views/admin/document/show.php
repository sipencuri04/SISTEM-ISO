<?php
include BASE_PATH . '/app/views/admin/layout/header.php';
include BASE_PATH . '/app/views/admin/layout/sidebar.php';
?>

<div class="content">
    <div class="card">

        <div class="header">
            <h2>📄 Detail Dokumen – Validasi Admin ISO</h2>
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
                <td>Uraian / Alasan Perubahan</td>
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
            // file ada di /public/uploads
            // file ada di /public/uploads
            $baseUrl = str_replace('/index.php', '', BASE_URL);
            $fileUrl = $baseUrl . '/' . $document['file_path'];
            
            // Cek fisik file di server untuk menghindari redirect login (jika file hilang)
            $localAbsPath = BASE_PATH . '/public/' . $document['file_path'];
            $isFileExists = file_exists($localAbsPath);

            $ext = strtolower(pathinfo($document['file_path'], PATHINFO_EXTENSION));
            ?>

            <?php if (!$isFileExists): ?>
                <div class="alert alert-danger" style="background:#fee2e2; color:#991b1b; padding:15px; border-radius:12px; border:1px solid #fca5a5;">
                    ⚠️ <b>File fisik tidak ditemukan di server.</b><br>
                    Kemungkinan file telah terhapus atau belum terupload dengan benar.<br>
                    <small>Path: <?= htmlspecialchars($document['file_path']) ?></small>
                </div>
            <?php elseif ($ext === 'pdf'): ?>
                <iframe src="<?= $fileUrl ?>" width="100%" height="600px" style="border:1px solid #e2e8f0; border-radius:12px;"></iframe>
                
                <div style="margin-top:10px; text-align:right;">
                    <a href="<?= $fileUrl; ?>"
                       target="_blank"
                       class="back"
                       style="font-weight:600">
                        ⬇ Download PDF
                    </a>
                </div>

                <div class="note">
                    File ini merupakan dokumen usulan / revisi yang diajukan oleh user.
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
               href="<?= BASE_URL_INDEX ?>?controller=Admin&action=approve&id=<?= $document['id']; ?>"
               onclick="return confirm('Setujui dokumen ini dan lanjut ke MR?')">
               ✔ Approve
            </a>

            <a class="reject"
               href="<?= BASE_URL_INDEX ?>?controller=Admin&action=reject&id=<?= $document['id']; ?>"
               onclick="return confirm('Tolak dokumen ini?')">
               ✖ Reject
            </a>

            <a class="back"
               href="<?= BASE_URL_INDEX ?>?controller=Admin&action=index">
               ← Kembali
            </a>
        </div>

    </div>
</div>
