<?php

include '../app/views/admin/layout/header.php';
include '../app/views/admin/layout/sidebar.php';
?>

<div class="content">
    <h2>Manajemen User</h2>

    <a href="<?= BASE_URL ?>?controller=User&action=userCreate"
        style="padding:8px 14px;background:#22c55e;color:#fff;
                border-radius:8px;text-decoration:none;">
            + Tambah User
    </a>


    <table border="1" cellpadding="10" cellspacing="0"
           style="margin-top:15px;width:100%;background:#fff;">
        <thead>
            <tr style="background:#f3f4f6;">
                <th>No</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Departemen</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; foreach ($users as $u): ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $u['nama']; ?></td>
                <td><?= $u['username']; ?></td>
                <td><?= $u['departemen']; ?></td>
                <td><?= strtoupper($u['role']); ?></td>
                <td>
                    <a href="index.php?action=userEdit&id=<?= $u['id']; ?>">Edit</a> |
                    <a href="index.php?action=userDelete&id=<?= $u['id']; ?>"
                       onclick="return confirm('Hapus user ini?')">
                       Hapus
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../app/views/admin/layout/footer.php'; ?>
