<?php
include BASE_PATH . '/app/views/gm/layout/header.php';
include BASE_PATH . '/app/views/gm/layout/sidebar.php';
?>

<div class="content">
    <h2>Pengesahan Dokumen – GM</h2>

    <table width="100%" cellpadding="10" cellspacing="0"
           style="background:#fff;border-radius:10px">

        <tr style="background:#f3f4f6">
            <th>No</th>
            <th>Kode</th>
            <th>Nama Dokumen</th>
            <th>Departemen</th>
            <th>Status</th>
            <th width="200">Aksi</th>
        </tr>

        <?php if (empty($documents)): ?>
        <tr>
            <td colspan="6" align="center">Tidak ada dokumen</td>
        </tr>
        <?php endif; ?>

        <?php $no=1; foreach ($documents as $doc): ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $doc['kode_dokumen']; ?></td>
            <td><?= $doc['nama_dokumen']; ?></td>
            <td><?= $doc['departemen']; ?></td>
            <td><?= $doc['status']; ?></td>
            <td>
                <a href="<?= BASE_URL ?>?controller=Gm&action=show&id=<?= $doc['id']; ?>">
                    🔍 Lihat
                </a> |
                <a href="<?= BASE_URL ?>?controller=Gm&action=approve&id=<?= $doc['id']; ?>"
                   onclick="return confirm('Sahkan dokumen ini?')"
                   style="color:green">
                    ✅ Sahkan
                </a> |
                <a href="<?= BASE_URL ?>?controller=Gm&action=reject&id=<?= $doc['id']; ?>"
                   onclick="return confirm('Tolak dokumen ini?')"
                   style="color:red">
                    ❌ Tolak
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
