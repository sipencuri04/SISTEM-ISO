<?php
include BASE_PATH . '/app/views/gm/layout/header.php';
include BASE_PATH . '/app/views/gm/layout/sidebar.php';
?>

<div class="content">
    <div class="card">

        <div class="header">
            <h2>🏁 Pengesahan Dokumen – GM</h2>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Dokumen</th>
                    <th>Judul Dokumen</th>
                    <th>Departemen</th>
                    <th>Status</th>
                    <th width="220">Aksi</th>
                </tr>
            </thead>
            <tbody>

            <?php if (empty($documents)): ?>
                <tr>
                    <td colspan="6" align="center" class="muted">
                        Tidak ada dokumen untuk disahkan
                    </td>
                </tr>
            <?php else: ?>
                <?php $no=1; foreach ($documents as $doc): ?>
                <tr>
                    <td><?= $no++; ?></td>

                    <td><?= htmlspecialchars($doc['kode_dokumen']); ?></td>

                    <td>
                        <?= htmlspecialchars($doc['judul_baru'] ?? $doc['nama_dokumen']); ?>
                    </td>

                    <td><?= htmlspecialchars($doc['departemen']); ?></td>

                    <td>
                        <?php
                        if (str_contains($doc['status'], 'Menunggu')) {
                            echo '<span class="badge wait">'.$doc['status'].'</span>';
                        } elseif ($doc['status'] === 'Approved') {
                            echo '<span class="badge ok">Approved</span>';
                        } else {
                            echo '<span class="badge no">'.$doc['status'].'</span>';
                        }
                        ?>
                    </td>

                    <td class="action">
                        <a class="view"
                           href="<?= BASE_URL_INDEX ?>?controller=Gm&action=show&id=<?= $doc['id']; ?>">
                           🔍 Lihat
                        </a>

                        <a class="approve"
                           href="<?= BASE_URL_INDEX ?>?controller=Gm&action=approve&id=<?= $doc['id']; ?>"
                           onclick="return confirm('Sahkan dokumen ini?')">
                           ✅ Sahkan
                        </a>

                        <a class="reject"
                           href="<?= BASE_URL_INDEX ?>?controller=Gm&action=reject&id=<?= $doc['id']; ?>"
                           onclick="return confirm('Tolak dokumen ini?')">
                           ❌ Tolak
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>

            </tbody>
        </table>

    </div>
</div>
