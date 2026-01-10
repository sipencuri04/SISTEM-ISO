<?php
$pageTitle = 'History Dokumen';
include BASE_PATH . '/app/views/admin/layout/header.php';
include BASE_PATH . '/app/views/admin/layout/sidebar.php';
?>

<div class="content">
    <div style="margin-bottom:var(--spacing-lg);">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <div>
                <h2>📜 History Pengajuan Dokumen</h2>
                <p>Riwayat semua pengajuan dokumen di sistem</p>
            </div>
            <div style="position:relative; width:300px;">
                <input type="text" 
                       id="searchInput" 
                       class="form-control" 
                       placeholder="🔍 Cari dokumen..." 
                       onkeyup="searchTable()"
                       style="padding-left:40px;">
                <span style="position:absolute; left:12px; top:50%; transform:translateY(-50%); font-size:18px;">🔍</span>
            </div>
        </div>
    </div>

    <div class="table-container">
        <table id="historyTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Dokumen</th>
                    <th>Judul Dokumen</th>
                    <th>Versi</th>
                    <th>Departemen</th>
                    <th>Jenis Pengajuan</th>
                    <th>Status</th>
                    <th>Tanggal Pengajuan</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($documents)): ?>
                    <tr>
                        <td colspan="8" style="text-align:center; padding:40px; color:var(--text-secondary);">
                            Belum ada history pengajuan dokumen
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($documents as $index => $doc): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><strong><?= e($doc['kode_dokumen']) ?></strong></td>
                            <td>
                                <div style="font-weight:600; color:var(--text-primary); margin-bottom:4px;">
                                    <?= e($doc['judul_baru'] ?? $doc['nama_dokumen']) ?>
                                </div>
                                <div style="font-size:12px; color:var(--text-secondary);">
                                    User: <?= e($doc['pengaju'], '-') ?>
                                </div>
                            </td>
                            <td>
                                <span class="badge info">
                                    <?= e($doc['versi'], 'V1.0') ?>
                                </span>
                            </td>
                            <td><?= e($doc['departemen'], '-') ?></td>
                            <td><?= e($doc['jenis_pengajuan'], '-') ?></td>
                            <td><?= statusBadge($doc['status']) ?></td>
                            <td><?= formatDateTime($doc['created_at']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function searchTable() {
    let input = document.getElementById("searchInput");
    let filter = input.value.toUpperCase();
    let table = document.getElementById("historyTable");
    let tr = table.getElementsByTagName("tr");

    for (let i = 1; i < tr.length; i++) {
        let textContent = tr[i].textContent || tr[i].innerText;
        if (textContent.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
        } else {
            tr[i].style.display = "none";
        }
    }
}
</script>

<?php include BASE_PATH . '/app/views/admin/layout/footer.php'; ?>
