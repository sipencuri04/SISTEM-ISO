<?php
include BASE_PATH . '/app/views/hod/layout/header.php';
include BASE_PATH . '/app/views/hod/layout/sidebar.php';
?>

<style>
.content{
    padding:24px;
    background:#f1f5f9;
    min-height:100vh;
    font-family:system-ui, -apple-system, BlinkMacSystemFont;
}

.card{
    background:#ffffff;
    padding:24px;
    border-radius:16px;
    box-shadow:0 10px 25px rgba(0,0,0,.06);
}

.card h2{
    margin-bottom:20px;
    font-size:20px;
}

/* ===== TABLE ===== */
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
}

.table tbody tr:hover{
    background:#f9fafb;
}

/* ===== BADGE ===== */
.badge{
    padding:4px 12px;
    border-radius:999px;
    font-size:12px;
    font-weight:600;
}

.badge-add{
    background:#dcfce7;
    color:#166534;
}

.badge-revise{
    background:#fef3c7;
    color:#92400e;
}

/* ===== ACTION ===== */
.action a{
    text-decoration:none;
    font-weight:600;
    font-size:13px;
    margin-right:10px;
}

.view{color:#2563eb;}
.approve{color:#16a34a;}
.reject{color:#dc2626;}
</style>

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
                           href="<?= BASE_URL ?>?controller=Hod&action=show&id=<?= $doc['id']; ?>">
                            Lihat
                        </a>

                        <a class="approve"
                           href="<?= BASE_URL ?>?controller=Hod&action=approve&id=<?= $doc['id']; ?>"
                           onclick="return confirm('Setujui dokumen ini?')">
                            Approve
                        </a>

                        <a class="reject"
                           href="<?= BASE_URL ?>?controller=Hod&action=reject&id=<?= $doc['id']; ?>"
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
