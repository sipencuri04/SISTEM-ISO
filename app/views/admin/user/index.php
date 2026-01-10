<?php
$pageTitle = 'Kelola User';
include BASE_PATH . '/app/views/admin/layout/header.php';
include BASE_PATH . '/app/views/admin/layout/sidebar.php';
?>

<div class="content">
    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:var(--spacing-lg);">
            <div>
                <h2>👤 Manajemen User</h2>
                <p>Kelola akses pengguna sistem</p>
            </div>
            <a href="<?= BASE_URL_INDEX ?>?controller=User&action=userCreate" class="btn btn-primary">
                ➕ Tambah User
            </a>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Departemen</th>
                        <th>Role</th>
                        <th style="text-align:right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($users)): ?>
                    <tr>
                        <td colspan="6" style="text-align:center; padding:40px; color:var(--text-secondary);">
                            Data user belum tersedia
                        </td>
                    </tr>
                <?php else: ?>
                    <?php $no=1; foreach ($users as $u): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><strong><?= e($u['nama']) ?></strong></td>
                        <td><?= e($u['username']) ?></td>
                        <td><?= e($u['departemen'], '-') ?></td>
                        <td>
                            <?php
                            $role = $u['role'] ?? '';
                            $badgeClass = match(strtolower($role)) {
                                'admin' => 'danger',
                                'gm' => 'success',
                                'mr' => 'info',
                                'hod' => 'warning',
                                'pic' => 'info',
                                default => 'info'
                            };
                            ?>
                            <span class="badge <?= $badgeClass ?>">
                                <?= strtoupper($role) ?>
                            </span>
                        </td>
                        <td style="text-align:right;">
                            <a href="<?= BASE_URL_INDEX ?>?controller=User&action=userEdit&id=<?= $u['id'] ?>" 
                               class="btn btn-outline" style="margin-right:8px;">
                                ✏️ Edit
                            </a>
                            <a href="<?= BASE_URL_INDEX ?>?controller=User&action=userDelete&id=<?= $u['id'] ?>"
                               class="btn btn-danger"
                               onclick="return confirm('Hapus user ini?')">
                                🗑️ Hapus
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include BASE_PATH . '/app/views/admin/layout/footer.php'; ?>
