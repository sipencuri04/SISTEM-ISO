<?php
// 🔐 PROTEKSI LOGIN
if (!isset($_SESSION['user'])) {
    header("Location: " . BASE_URL . "?controller=Auth&action=login");
    exit;
}

include BASE_PATH . '/app/views/pic/layout/header.php';
include BASE_PATH . '/app/views/pic/layout/sidebar.php';
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
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.header h2{
    margin:0;
    font-size:20px;
}

.btn{
    background:#22c55e;
    color:#fff;
    padding:10px 16px;
    border-radius:10px;
    text-decoration:none;
    font-weight:600;
    font-size:14px;
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

.muted{
    color:#94a3b8;
    font-style:italic;
}
</style>

<div class="content">
    <div class="card">

        <div class="header">
            <h2>📄 Daftar Pengajuan Dokumen Saya</h2>
            <a href="<?= BASE_URL ?>?controller=Document&action=create" class="btn">
                + Ajukan Dokumen
            </a>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Judul Dokumen Baru</th>
                    <th>Judul Lama</th>
                    <th>Jenis</th>
                    <th>Pengajuan</th>
                    <th>Revisi</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>
            </thead>

            <tbody>
            <?php if (empty($documents)): ?>
                <tr>
                    <td colspan="8" class="muted" align="center">
                        Belum ada pengajuan dokumen
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($documents as $doc): ?>
                <tr>
                    <td><?= htmlspecialchars($doc['kode_dokumen']); ?></td>

                    <td><?= htmlspecialchars($doc['judul_baru'] ?? $doc['nama_dokumen']); ?></td>

                    <td>
                        <?= !empty($doc['judul_lama']) 
                            ? htmlspecialchars($doc['judul_lama']) 
                            : '<span class="muted">-</span>' ?>
                    </td>

                    <td><?= htmlspecialchars($doc['jenis_dokumen']); ?></td>

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

                    <td><?= date('d M Y', strtotime($doc['created_at'])); ?></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>

    </div>
</div>
