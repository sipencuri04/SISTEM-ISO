<?php
include BASE_PATH . '/app/views/admin/layout/header.php';
include BASE_PATH . '/app/views/admin/layout/sidebar.php';
?>

<div class="content">
    <h2>Approval Dokumen – Admin ISO</h2>

    <table width="100%" cellpadding="10" cellspacing="0"
           style="background:#fff;border-radius:10px">

        <tr style="background:#f3f4f6">
            <th>No</th>
            <th>Kode Dokumen</th>
            <th>Nama Dokumen</th>
            <th>Departemen</th>
            <th>Jenis</th>
            <th>Status</th>
            <th width="220">Aksi</th>
        </tr>

        <?php if (empty($documents)): ?>
        <tr>
            <td colspan="7" align="center">Tidak ada dokumen menunggu approval</td>
        </tr>
        <?php endif; ?>

        <?php $no = 1; foreach ($documents as $doc): ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $doc['kode_dokumen']; ?></td>
            <td><?= $doc['nama_dokumen']; ?></td>
            <td><?= $doc['departemen']; ?></td>
            <td><?= ucfirst($doc['jenis_pengajuan']); ?></td>
            <td>
                <span style="padding:4px 8px;border-radius:6px;
                             background:#fde68a;color:#92400e">
                    <?= $doc['status']; ?>
                </span>
            </td>
            <td>
                <!-- LIHAT -->
                <a href="<?= BASE_URL ?>?controller=Admin&action=show&id=<?= $doc['id']; ?>"
                   style="margin-right:8px">
                    🔍 Lihat
                </a>

                <!-- APPROVE -->
                <a href="<?= BASE_URL ?>?controller=Admin&action=approve&id=<?= $doc['id']; ?>"
                   onclick="return confirm('Setujui dokumen ini dan lanjut ke MR?')"
                   style="color:green;margin-right:8px">
                    ✅ Approve
                </a>

                <!-- REJECT -->
                <a href="<?= BASE_URL ?>?controller=Admin&action=reject&id=<?= $doc['id']; ?>"
                   onclick="return confirm('Tolak dokumen ini?')"
                   style="color:red">
                    ❌ Reject
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
