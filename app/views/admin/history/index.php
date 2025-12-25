<?php include BASE_PATH . '/app/views/admin/layout/sidebar.php'; ?>

<div class="content">
    <div class="header">
        <h1>📜 History Pengajuan Dokumen</h1>
        
        <div class="search-box">
             <input type="text" id="searchInput" placeholder="Cari dokumen..." onkeyup="searchTable()">
             <span class="search-icon">🔍</span>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table" id="historyTable">
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
                            <td colspan="8" class="text-center">Belum ada history pengajuan.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($documents as $index => $doc): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td class="fw-bold"><?= htmlspecialchars($doc['kode_dokumen']) ?></td>
                                <td>
                                    <div class="doc-title"><?= htmlspecialchars($doc['judul_baru']) ?></div>
                                    <div class="doc-subtitle">User: <?= htmlspecialchars($doc['pengaju'] ?? '-') ?></div>
                                </td>
                                <td><span class="badge badge-gray">V<?= htmlspecialchars($doc['versi']) ?></span></td>
                                <td><?= htmlspecialchars($doc['departemen']) ?></td>
                                <td><?= htmlspecialchars($doc['jenis_pengajuan']) ?></td>
                                <td>
                                    <?php
                                    $statusClass = 'badge-secondary';
                                    if (strpos($doc['status'], 'Disetujui') !== false || $doc['status'] == 'Selesai') {
                                        $statusClass = 'badge-success';
                                    } elseif (strpos($doc['status'], 'Ditolak') !== false) {
                                        $statusClass = 'badge-danger';
                                    } elseif (strpos($doc['status'], 'Menunggu') !== false) {
                                        $statusClass = 'badge-warning';
                                    }
                                    ?>
                                    <span class="badge <?= $statusClass ?>"><?= htmlspecialchars($doc['status']) ?></span>
                                </td>
                                <td><?= date('d M Y H:i', strtotime($doc['created_at'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    /* VARIABLES */
    :root {
        --primary: #4F46E5;
        --secondary: #64748B;
        --success: #10B981;
        --warning: #F59E0B;
        --danger: #EF4444;
        --light: #F8FAFC;
        --dark: #1E293B;
        --border: #E2E8F0;
        --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --radius: 12px;
    }

    /* LAYOUT & TYPOGRAPHY */
    body {
        font-family: 'Inter', sans-serif;
        background-color: #F1F5F9;
        color: var(--dark);
    }
    
    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }
    
    .header h1 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #111827;
        margin: 0;
    }

    /* SEARCH BOX */
    .search-box {
        position: relative;
        width: 300px;
    }
    
    .search-box input {
        width: 100%;
        padding: 0.75rem 1rem 0.75rem 2.5rem;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        outline: none;
        transition: all 0.2s;
        font-size: 0.875rem;
    }
    
    .search-box input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }
    
    .search-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--secondary);
        font-size: 1rem;
    }

    /* CARD STYLING */
    .card {
        background: white;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        overflow: hidden;
        border: 1px solid var(--border);
    }

    /* TABLE STYLING */
    .table-responsive {
        overflow-x: auto;
    }
    
    .table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .table th {
        background: #F8FAFC;
        padding: 1rem;
        text-align: left;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--secondary);
        border-bottom: 1px solid var(--border);
    }
    
    .table td {
        padding: 1rem;
        border-bottom: 1px solid var(--border);
        vertical-align: middle;
        font-size: 0.875rem;
    }
    
    .table tbody tr:last-child td {
        border-bottom: none;
    }
    
    .table tbody tr:hover {
        background-color: #F8FAFC;
    }

    /* BADGES */
    .badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        line-height: 1;
    }
    
    .badge-success { background: #DCFCE7; color: #166534; }
    .badge-danger { background: #FEE2E2; color: #991B1B; }
    .badge-warning { background: #FEF3C7; color: #92400E; }
    .badge-secondary { background: #F1F5F9; color: #475569; }
    .badge-gray { background: #E2E8F0; color: #475569; }

    /* UTILS */
    .fw-bold { font-weight: 600; }
    .text-center { text-align: center; }
    
    .doc-title {
        font-weight: 600;
        color: #111827;
        margin-bottom: 0.25rem;
    }
    
    .doc-subtitle {
        font-size: 0.75rem;
        color: var(--secondary);
    }

</style>

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
