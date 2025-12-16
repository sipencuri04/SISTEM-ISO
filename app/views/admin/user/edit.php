<?php

include '../app/views/admin/layout/header.php';
include '../app/views/admin/layout/sidebar.php';
?>

<div class="content">
    <h2>Edit User</h2>

    <form method="POST" action="index.php?action=userUpdate">

        <input type="hidden" name="id" value="<?= $user['id']; ?>">

        <label>Nama</label><br>
        <input type="text" name="nama" value="<?= $user['nama']; ?>" required><br><br>

        <label>Username</label><br>
        <input type="text" name="username" value="<?= $user['username']; ?>" required><br><br>

        <label>Password (kosongkan jika tidak diubah)</label><br>
        <input type="password" name="password"><br><br>

        <label>Departemen</label><br>
        <select name="departemen">
            <option <?= $user['departemen']=='Accounting'?'selected':''; ?>>Accounting</option>
            <option <?= $user['departemen']=='Engineering'?'selected':''; ?>>Engineering</option>
            <option <?= $user['departemen']=='Human Resources'?'selected':''; ?>>Human Resources</option>
            <option <?= $user['departemen']=='IT'?'selected':''; ?>>IT</option>
        </select><br><br>

        <label>Role</label><br>
        <select name="role">
            <option value="admin" <?= $user['role']=='admin'?'selected':''; ?>>Admin</option>
            <option value="pic" <?= $user['role']=='pic'?'selected':''; ?>>PIC</option>
            <option value="hod" <?= $user['role']=='hod'?'selected':''; ?>>HOD</option>
            <option value="mr" <?= $user['role']=='mr'?'selected':''; ?>>MR</option>
            <option value="gm" <?= $user['role']=='gm'?'selected':''; ?>>GM</option>
        </select><br><br>

        <button type="submit">Update</button>
        <a href="index.php?action=userIndex">Kembali</a>
    </form>
</div>

<?php include '../app/views/admin/layout/footer.php'; ?>
