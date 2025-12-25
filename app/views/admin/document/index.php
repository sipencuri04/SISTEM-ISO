<?php
include BASE_PATH . '/app/views/admin/layout/header.php';
include BASE_PATH . '/app/views/admin/layout/sidebar.php';
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

.table thead th{
    text-align:left;
    padding:12px;
    background:#f8fafc;
    color:#475569;
    font-weight:600;
    border-bottom:1px solid #e5e7eb;
}

.table tbody td{
    padding:12px;
    border-bottom:1px solid #e5e7eb;
    color:#334155;
    vertical-align:top;
}

.table tbody tr:hover{
    background:#f9fafb;
}

.badge{
    padding:4px 12px;
    border-radius:999px;
    font-size:12px;
    font-weight:600;
    display:inline-block;
}

.wait{background:#fef3c7;color:#92400e;}
.ok{background:#dcfce7;color:#166534;}
.no{background:#fee2e2;color:#991b1b;}

.action a{
    text-decoration:none;
    font-weight:600;
    font-size:13px;
    margin-right:10px;
}

.view{color:#2563eb;}
.approve{color:#16a34a;}
.reject{color:#dc2626;}
.muted{color:#94a3b8;}
</style>

<div class="content">
    <div class="card">

        <div class="header">
            <h2>✅ Approval Dokumen – Admin ISO</h2>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Judul Dokumen Baru</th>
                    <th>Departemen</th>
                    <th>Jenis Pengajuan</th>
                    <th>Revisi</th>
                    <th>Status</th>
                    <th width="220">Aksi</th>
                </tr>
            </thead>
            <tbody>

            <?php if (empty($documents)): ?>
                <tr>
                    <td colspan="8" align="center" class="muted">
                        Tidak ada dokumen menunggu approval
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
                    <td><?= strtoupper($doc['jenis_pengajuan']); ?></td>
                    <td><?= htmlspecialchars($doc['versi']); ?></td>

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
                           href="<?= BASE_URL ?>?controller=Admin&action=show&id=<?= $doc['id']; ?>">
                           🔍 Lihat
                        </a>

                        <a class="approve"
                           href="<?= BASE_URL ?>?controller=Admin&action=approve&id=<?= $doc['id']; ?>"
                           onclick="return confirm('Setujui dokumen ini dan lanjut ke MR?')">
                           ✅ Approve
                        </a>

                        <a class="reject"
                           href="<?= BASE_URL ?>?controller=Admin&action=reject&id=<?= $doc['id']; ?>"
                           onclick="return confirm('Tolak dokumen ini?')">
                           ❌ Reject
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>

            </tbody>
        </table>

    </div>
</div>
