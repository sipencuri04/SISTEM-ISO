<?php
include BASE_PATH . '/app/views/hod/layout/header.php';
include BASE_PATH . '/app/views/hod/layout/sidebar.php';
?>

<div class="content">
    <h2>Approval Dokumen - HOD</h2>

    <table width="100%" cellpadding="10" cellspacing="0">
        <tr style="background:#f3f4f6">
            <th>Kode</th>
            <th>Nama Dokumen</th>
            <th>Jenis</th>
            <th>Departemen</th>
            <th>Aksi</th>
        </tr>

        <?php if (empty($documents)): ?>
            <tr>
                <td colspan="5" align="center">Tidak ada pengajuan</td>
            </tr>
        <?php endif; ?>

        <?php foreach ($documents as $doc): ?>
        <tr>
            <td><?= $doc['kode_dokumen']; ?></td>
            <td><?= $doc['nama_dokumen']; ?></td>
            <td><?= $doc['jenis_pengajuan']; ?></td>
            <td><?= $doc['departemen']; ?></td>
            <td>
                <a href="<?= BASE_URL ?>?controller=Hod&action=show&id=<?= $doc['id']; ?>">
                    Lihat
                </a>

                |
                <a href="<?= BASE_URL ?>?controller=Hod&action=approve&id=<?= $doc['id']; ?>"
                   onclick="return confirm('Setujui dokumen ini?')"
                   style="color:green">Approve</a>
                |
                <a href="<?= BASE_URL ?>?controller=Hod&action=reject&id=<?= $doc['id']; ?>"
                   onclick="return confirm('Tolak dokumen ini?')"
                   style="color:red">Reject</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
