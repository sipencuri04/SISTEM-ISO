<!DOCTYPE html>
<html>
<head>
    <title>Register User ISO</title>
</head>
<body>

<h3>Register User</h3>

<?php if (isset($_GET['error']) && $_GET['error'] == 'exists'): ?>
    <p style="color:red;">Username sudah digunakan</p>
<?php endif; ?>

<form method="POST" action="index.php?action=store">

    <div>
        <label>Nama</label>
        <input type="text" name="nama" required>
    </div>

    <div>
        <label>Username</label>
        <input type="text" name="username" required>
    </div>

    <div>
        <label>Password</label>
        <input type="password" name="password" required>
    </div>

    <div>
        <label>Departemen</label>
        <select name="departemen" required>
            <option value="">-- Pilih --</option>
            <option>Accounting</option>
            <option>Engineering</option>
            <option>F&B Product</option>
            <option>F&B Service</option>
            <option>Front Office</option>
            <option>Housekeeping</option>
            <option>Human Resources</option>
            <option>Information Technology</option>
            <option>Purchasing</option>
            <option>Sales Marketing</option>
        </select>
    </div>

    <div>
        <label>Role</label>
        <select name="role" required>
            <option value="">-- Pilih Role --</option>
            <option value="pic">PIC</option>
            <option value="hod">HOD</option>
            <option value="mr">MR</option>
            <option value="gm">GM</option>
            <option value="admin">Admin</option>
        </select>
    </div>

    <button type="submit">Register</button>
</form>

<p>
    Sudah punya akun?
    <a href="index.php?action=login">Login</a>
</p>

</body>
</html>
