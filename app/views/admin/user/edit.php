<?php
$pageTitle = 'Edit User';
include BASE_PATH . '/app/views/admin/layout/header.php';
include BASE_PATH . '/app/views/admin/layout/sidebar.php';
?>

<div class="content">
    <div class="card" style="max-width:600px;">
        <div style="margin-bottom:var(--spacing-lg);">
            <h2>✏️ Edit User</h2>
            <p>Ubah informasi user</p>
        </div>

        <form method="POST" action="<?= BASE_URL_INDEX ?>?controller=User&action=userUpdate">
            <input type="hidden" name="id" value="<?= $user['id'] ?>">

            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" value="<?= e($user['nama']) ?>" required>
            </div>

            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?= e($user['username']) ?>" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Biarkan kosong jika tidak ingin mengubah">
                <small style="font-size:12px; color:var(--text-secondary); display:block; margin-top:4px;">
                    Kosongkan jika tidak ingin mengubah password
                </small>
            </div>

            <div class="form-group">
                <label>Departemen</label>
                <select name="departemen" class="form-control" required>
                    <option value="Accounting" <?= ($user['departemen']=='Accounting')?'selected':'' ?>>Accounting</option>
                    <option value="Engineering" <?= ($user['departemen']=='Engineering')?'selected':'' ?>>Engineering</option>
                    <option value="Human Resources" <?= ($user['departemen']=='Human Resources')?'selected':'' ?>>Human Resources</option>
                    <option value="IT" <?= ($user['departemen']=='IT')?'selected':'' ?>>IT</option>
                    <option value="Marketing" <?= ($user['departemen']=='Marketing')?'selected':'' ?>>Marketing</option>
                    <option value="Operations" <?= ($user['departemen']=='Operations')?'selected':'' ?>>Operations</option>
                </select>
            </div>

            <div class="form-group">
                <label>Role</label>
                <select name="role" class="form-control" required>
                    <option value="admin" <?= ($user['role']=='admin')?'selected':'' ?>>Admin</option>
                    <option value="pic" <?= ($user['role']=='pic')?'selected':'' ?>>PIC</option>
                    <option value="hod" <?= ($user['role']=='hod')?'selected':'' ?>>HOD (Head of Department)</option>
                    <option value="mr" <?= ($user['role']=='mr')?'selected':'' ?>>MR (Management Representative)</option>
                    <option value="gm" <?= ($user['role']=='gm')?'selected':'' ?>>GM (General Manager)</option>
                </select>
            </div>

            <div style="margin-top:var(--spacing-lg); display:flex; gap:12px;">
                <button type="submit" class="btn btn-primary">
                    💾 Update
                </button>
                <a href="<?= BASE_URL_INDEX ?>?controller=User&action=userIndex" class="btn btn-outline">
                    ← Kembali
                </a>
            </div>
        </form>
    </div>
</div>

<?php include BASE_PATH . '/app/views/admin/layout/footer.php'; ?>
