<?php
include BASE_PATH . '/app/views/admin/layout/header.php';
include BASE_PATH . '/app/views/admin/layout/sidebar.php';
?>

<style>
.content{
    padding:24px;
    background:#f1f5f9;
    min-height:100vh;
    font-family:system-ui, -apple-system, BlinkMacSystemFont;
}

.card{
    max-width:520px;
    background:#fff;
    padding:24px;
    border-radius:16px;
    box-shadow:0 10px 25px rgba(0,0,0,.06);
}

.header{
    margin-bottom:20px;
}

.header h2{
    margin:0;
    font-size:20px;
}

.form-group{
    margin-bottom:16px;
}

.form-group label{
    display:block;
    margin-bottom:6px;
    font-size:14px;
    font-weight:600;
    color:#334155;
}

.form-group input,
.form-group select{
    width:100%;
    padding:10px 12px;
    border:1px solid #e5e7eb;
    border-radius:10px;
    font-size:14px;
}

.form-group input:focus,
.form-group select:focus{
    outline:none;
    border-color:#22c55e;
}

.actions{
    margin-top:20px;
}

.btn{
    background:#22c55e;
    color:#fff;
    padding:10px 18px;
    border-radius:10px;
    border:none;
    cursor:pointer;
    font-weight:600;
    font-size:14px;
    text-decoration:none;
}

.btn-secondary{
    margin-left:12px;
    color:#475569;
    text-decoration:none;
    font-weight:600;
}
</style>

<div class="content">
    <div class="card">

        <div class="header">
            <h2>➕ Tambah User</h2>
        </div>

        <form method="POST" action="<?= BASE_URL ?>?controller=User&action=userStore">

            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="nama" required>
            </div>

            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <div class="form-group">
                <label>Departemen</label>
                <select name="departemen" required>
                    <option value="">-- Pilih Departemen --</option>
                    <option value="Accounting">Accounting</option>
                    <option value="Engineering">Engineering</option>
                    <option value="Human Resources">Human Resources</option>
                    <option value="IT">IT</option>
                </select>
            </div>

            <div class="form-group">
                <label>Role</label>
                <select name="role" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="admin">Admin</option>
                    <option value="pic">PIC</option>
                    <option value="hod">HOD</option>
                    <option value="mr">MR</option>
                    <option value="gm">GM</option>
                </select>
            </div>

            <div class="actions">
                <button type="submit" class="btn">Simpan</button>
                <a href="<?= BASE_URL ?>?controller=User&action=userIndex"
                   class="btn-secondary">
                    Batal
                </a>
            </div>

        </form>
    </div>
</div>
