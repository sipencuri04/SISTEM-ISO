<?php
include BASE_PATH . '/app/views/mr/layout/header.php';
include BASE_PATH . '/app/views/mr/layout/sidebar.php';
?>

<div class="content">
    <h2>Review Dokumen – MR</h2>

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
                <a href="<?= BASE_URL ?>?controller=Mr&action=show&id=<?= $doc['id']; ?>">
                    🔍 Lihat
                </a> |
                <a href="<?= BASE_URL ?>?controller=Mr&action=approve&id=<?= $doc['id']; ?>"
                   onclick="return confirm('Setujui & lanjut ke GM?')"
                   style="color:green">
                    ✅ Approve
                </a> |
                <a href="<?= BASE_URL ?>?controller=Mr&action=reject&id=<?= $doc['id']; ?>"
                   onclick="return confirm('Tolak dokumen ini?')"
                   style="color:red">
                    ❌ Reject
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
