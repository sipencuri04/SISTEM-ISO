<?php
$pageTitle = 'Tambah User';
include BASE_PATH . '/app/views/admin/layout/header.php';
include BASE_PATH . '/app/views/admin/layout/sidebar.php';
?>

<div class="content">
    <div class="card" style="max-width:600px;">
        <div style="margin-bottom:var(--spacing-lg);">
            <h2>➕ Tambah User Baru</h2>
            <p>Isi form di bawah untuk menambahkan user baru</p>
        </div>

        <form method="POST" action="<?= BASE_URL_INDEX ?>?controller=User&action=userStore">
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" required placeholder="Masukkan nama lengkap">
            </div>

            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required placeholder="Username untuk login">
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required placeholder="Minimal 6 karakter">
            </div>

            <div class="form-group">
                <label>Departemen</label>
                <select name="departemen" class="form-control" required>
                    <option value="">-- Pilih Departemen --</option>
                    <option value="Accounting">Accounting</option>
                    <option value="Engineering">Engineering</option>
                    <option value="Human Resources">Human Resources</option>
                    <option value="IT">IT</option>
                    <option value="Marketing">Marketing</option>
                    <option value="Operations">Operations</option>
                </select>
            </div>

            <div class="form-group">
                <label>Role</label>
                <select name="role" class="form-control" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="admin">Admin</option>
                    <option value="pic">PIC</option>
                    <option value="hod">HOD (Head of Department)</option>
                    <option value="mr">MR (Management Representative)</option>
                    <option value="gm">GM (General Manager)</option>
                </select>
            </div>

            <div style="margin-top:var(--spacing-lg); display:flex; gap:12px;">
                <button type="submit" class="btn btn-primary">
                    💾 Simpan
                </button>
                <a href="<?= BASE_URL_INDEX ?>?controller=User&action=userIndex" class="btn btn-outline">
                    ← Batal
                </a>
            </div>
        </form>
    </div>
</div>

<?php include BASE_PATH . '/app/views/admin/layout/footer.php'; ?>
