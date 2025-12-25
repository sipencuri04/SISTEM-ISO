<?php
include '../app/views/admin/layout/header.php';
include '../app/views/admin/layout/sidebar.php';
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

.admin{background:#fee2e2;color:#991b1b;}
.pic{background:#e0f2fe;color:#0369a1;}
.hod{background:#fef3c7;color:#92400e;}
.mr{background:#ede9fe;color:#5b21b6;}
.gm{background:#dcfce7;color:#166534;}

.action a{
    text-decoration:none;
    font-weight:600;
    font-size:13px;
    margin-right:8px;
}

.edit{color:#2563eb;}
.delete{color:#dc2626;}
</style>

<div class="content">
    <div class="card">

        <div class="header">
            <h2>👤 Manajemen User</h2>
            <a href="<?= BASE_URL ?>?controller=User&action=userCreate" class="btn">
                + Tambah User
            </a>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Departemen</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php if (empty($users)): ?>
                <tr>
                    <td colspan="6" align="center" style="color:#94a3b8">
                        Data user belum tersedia
                    </td>
                </tr>
            <?php else: ?>
                <?php $no=1; foreach ($users as $u): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($u['nama'] ?? ''); ?></td>
                    <td><?= htmlspecialchars($u['username'] ?? ''); ?></td>
                    <td><?= htmlspecialchars($u['departemen'] ?? ''); ?></td>
                    <td>
                        <span class="badge <?= $u['role'] ?? ''; ?>">
                            <?= strtoupper($u['role'] ?? ''); ?>
                        </span>
                    </td>

                    <td class="action">
                        <a class="edit"
                        href="<?= BASE_URL ?>?controller=User&action=userEdit&id=<?= $u['id']; ?>">
                            Edit
                        </a>

                        <a class="delete"
                        href="<?= BASE_URL ?>?controller=User&action=userDelete&id=<?= $u['id']; ?>"
                        onclick="return confirm('Hapus user ini?')">
                            Hapus
                        </a>
                    </td>

                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>

    </div>
</div>

<?php include '../app/views/admin/layout/footer.php'; ?>
