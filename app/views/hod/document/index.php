<?php
include BASE_PATH . '/app/views/hod/layout/header.php';
include BASE_PATH . '/app/views/hod/layout/sidebar.php';
?>

<div class="content">
    <div class="card">
        <h2>📄 Approval Dokumen - HOD</h2>

        <table class="table">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama Dokumen</th>
                    <th>Jenis</th>
                    <th>Departemen</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>

            <?php if (empty($documents)): ?>
                <tr>
                    <td colspan="5" align="center" style="color:#94a3b8">
                        Tidak ada pengajuan dokumen
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($documents as $doc): ?>
                <tr>
                    <td><?= htmlspecialchars($doc['kode_dokumen']); ?></td>
                    <td><?= htmlspecialchars($doc['nama_dokumen']); ?></td>
                    <td>
                        <span class="badge <?= $doc['jenis_pengajuan']=='Penambahan'?'badge-add':'badge-revise'; ?>">
                            <?= htmlspecialchars($doc['jenis_pengajuan']); ?>
                        </span>
                    </td>
                    <td><?= htmlspecialchars($doc['departemen']); ?></td>
                    <td class="action">
                        <a class="view"
                           href="<?= BASE_URL_INDEX ?>?controller=Hod&action=show&id=<?= $doc['id']; ?>">
                            Lihat
                        </a>

                        <a class="approve"
                           href="<?= BASE_URL_INDEX ?>?controller=Hod&action=approve&id=<?= $doc['id']; ?>"
                           onclick="return confirm('Setujui dokumen ini?')">
                            Approve
                        </a>

                        <a class="reject"
                           href="<?= BASE_URL_INDEX ?>?controller=Hod&action=reject&id=<?= $doc['id']; ?>"
                           onclick="return confirm('Tolak dokumen ini?')">
                            Reject
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>

            </tbody>
        </table>
    </div>
</div>
