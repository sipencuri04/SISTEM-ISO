<?php
include BASE_PATH . '/app/views/gm/layout/header.php';
include BASE_PATH . '/app/views/gm/layout/sidebar.php';
?>

<div class="content">
    <h2>Detail Dokumen (Pengesahan GM)</h2>

    <table cellpadding="8">
        <tr><td>Kode</td><td>: <?= $document['kode_dokumen']; ?></td></tr>
        <tr><td>Nama</td><td>: <?= $document['nama_dokumen']; ?></td></tr>
        <tr><td>Departemen</td><td>: <?= $document['departemen']; ?></td></tr>
        <tr><td>Status</td><td>: <?= $document['status']; ?></td></tr>
        <tr><td>Alasan</td><td>: <?= nl2br($document['alasan']); ?></td></tr>

        <?php if (!empty($document['deskripsi_perubahan'])): ?>
        <tr>
            <td>Deskripsi Perubahan</td>
            <td>: <?= nl2br($document['deskripsi_perubahan']); ?></td>
        </tr>
        <?php endif; ?>

        <tr>
            <td>File</td>
            <td>
                <a href="<?= BASE_URL . $document['file_path']; ?>" target="_blank">
                    Download / Lihat Dokumen
                </a>
            </td>
        </tr>
    </table>

    <br>

    <a href="<?= BASE_URL ?>?controller=Gm&action=approve&id=<?= $document['id']; ?>"
       onclick="return confirm('Sahkan dokumen ini?')"
       style="color:green;font-weight:bold">
       ✔ Sahkan (Final)
    </a>
    |
    <a href="<?= BASE_URL ?>?controller=Gm&action=reject&id=<?= $document['id']; ?>"
       onclick="return confirm('Tolak dokumen ini?')"
       style="color:red;font-weight:bold">
       ✖ Tolak
    </a>

    <br><br>
    <a href="<?= BASE_URL ?>?controller=Gm&action=index">← Kembali</a>
</div>
