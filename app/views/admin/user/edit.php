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
    max-width:600px;
}

.card h2{
    margin-bottom:20px;
    font-size:20px;
}

.form-group{
    margin-bottom:16px;
}

label{
    display:block;
    font-size:14px;
    font-weight:600;
    color:#334155;
    margin-bottom:6px;
}

input, select{
    width:100%;
    padding:10px 12px;
    border-radius:10px;
    border:1px solid #e5e7eb;
    font-size:14px;
}

input:focus, select:focus{
    outline:none;
    border-color:#22c55e;
}

.form-note{
    font-size:12px;
    color:#64748b;
    margin-top:4px;
}

.actions{
    display:flex;
    gap:12px;
    margin-top:24px;
}

.btn{
    padding:10px 18px;
    border-radius:10px;
    font-size:14px;
    font-weight:600;
    text-decoration:none;
    cursor:pointer;
}

.btn-primary{
    background:#22c55e;
    color:#fff;
    border:none;
}

.btn-secondary{
    background:#e5e7eb;
    color:#334155;
}
</style>

<div class="content">
    <div class="card">
        <h2>✏️ Edit User</h2>

        <form method="POST" action="<?= BASE_URL ?>?controller=User&action=userUpdate">

            <input type="hidden" name="id" value="<?= $user['id']; ?>">

            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="nama" value="<?= htmlspecialchars($user['nama']); ?>" required>
            </div>

            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" value="<?= htmlspecialchars($user['username']); ?>" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password">
                <div class="form-note">Kosongkan jika tidak ingin mengubah password</div>
            </div>

            <div class="form-group">
                <label>Departemen</label>
                <select name="departemen">
                    <option <?= $user['departemen']=='Accounting'?'selected':''; ?>>Accounting</option>
                    <option <?= $user['departemen']=='Engineering'?'selected':''; ?>>Engineering</option>
                    <option <?= $user['departemen']=='Human Resources'?'selected':''; ?>>Human Resources</option>
                    <option <?= $user['departemen']=='IT'?'selected':''; ?>>IT</option>
                </select>
            </div>

            <div class="form-group">
                <label>Role</label>
                <select name="role">
                    <option value="admin" <?= $user['role']=='admin'?'selected':''; ?>>Admin</option>
                    <option value="pic" <?= $user['role']=='pic'?'selected':''; ?>>PIC</option>
                    <option value="hod" <?= $user['role']=='hod'?'selected':''; ?>>HOD</option>
                    <option value="mr" <?= $user['role']=='mr'?'selected':''; ?>>MR</option>
                    <option value="gm" <?= $user['role']=='gm'?'selected':''; ?>>GM</option>
                </select>
            </div>

            <div class="actions">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="<?= BASE_URL ?>?controller=User&action=userIndex" class="btn btn-secondary">
                    Kembali
                </a>
            </div>

        </form>
    </div>
</div>

<?php include '../app/views/admin/layout/footer.php'; ?>
