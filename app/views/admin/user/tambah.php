<?php
include BASE_PATH . '/app/views/admin/layout/header.php';
include BASE_PATH . '/app/views/admin/layout/sidebar.php';
?>

<div class="content">
    <h2>Tambah User</h2>

    <form method="POST" action="<?= BASE_URL ?>?controller=User&action=userStore">

        <label>Nama</label><br>
        <input type="text" name="nama" required><br><br>

        <label>Username</label><br>
        <input type="text" name="username" required><br><br>

        <label>Password</label><br>
        <input type="password" name="password" required><br><br>

        <label>Departemen</label><br>
        <select name="departemen" required>
            <option value="">-- Pilih --</option>
            <option value="Accounting">Accounting</option>
            <option value="Engineering">Engineering</option>
            <option value="Human Resources">Human Resources</option>
            <option value="IT">IT</option>
        </select><br><br>

        <label>Role</label><br>
        <select name="role" required>
            <option value="">-- Pilih Role --</option>
            <option value="admin">Admin</option>
            <option value="pic">PIC</option>
            <option value="hod">HOD</option>
            <option value="mr">MR</option>
            <option value="gm">GM</option>
        </select><br><br>

        <button type="submit"
                style="padding:8px 16px;
                       background:#22c55e;
                       color:#fff;
                       border:none;
                       border-radius:8px;
                       cursor:pointer;">
            Simpan
        </button>

        <a href="<?= BASE_URL ?>?controller=User&action=userIndex"
           style="margin-left:10px;text-decoration:none;">
            Batal
        </a>
    </form>
</div>
