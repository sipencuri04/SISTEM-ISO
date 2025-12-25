<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Login ISO HR</title>

<style>
*{
    box-sizing:border-box;
    font-family:system-ui, -apple-system, BlinkMacSystemFont;
}

body{
    margin:0;
    min-height:100vh;
    background:#e5f7ef;
    display:flex;
    align-items:center;
    justify-content:center;
}

/* ===== CARD ===== */
.login-wrapper{
    width:100%;
    max-width:980px;
    background:#fff;
    border-radius:24px;
    overflow:hidden;
    box-shadow:0 20px 50px rgba(0,0,0,.15);
    display:flex;
}

/* ===== LEFT FORM ===== */
.login-form{
    width:50%;
    padding:48px;
}

.login-form h1{
    margin:0;
    font-size:32px;
    color:#0f172a;
}

.login-form p{
    margin:6px 0 32px;
    color:#64748b;
    font-size:14px;
}

.form-group{
    margin-bottom:18px;
}

.input-wrapper{
    position:relative;
}

.input-wrapper input{
    width:100%;
    padding:12px 14px 12px 44px;
    border-radius:12px;
    border:1px solid #e5e7eb;
    font-size:14px;
}

.input-wrapper input:focus{
    outline:none;
    border-color:#22c55e;
    box-shadow:0 0 0 3px rgba(34,197,94,.2);
}

.icon{
    position:absolute;
    top:50%;
    left:14px;
    transform:translateY(-50%);
    font-size:18px;
    color:#22c55e;
}

.form-extra{
    display:flex;
    justify-content:space-between;
    font-size:13px;
    margin-bottom:24px;
    color:#64748b;
}

.form-extra a{
    text-decoration:none;
    color:#22c55e;
    font-weight:600;
}

button{
    width:100%;
    padding:14px;
    border:none;
    border-radius:14px;
    background:linear-gradient(135deg,#22c55e,#16a34a);
    color:#fff;
    font-size:15px;
    font-weight:600;
    cursor:pointer;
}

button:hover{
    opacity:.95;
}

.register{
    text-align:center;
    margin-top:20px;
    font-size:13px;
    color:#64748b;
}

.register a{
    color:#22c55e;
    font-weight:600;
    text-decoration:none;
}

/* ===== RIGHT PANEL ===== */
.login-info{
    width:50%;
    background:linear-gradient(135deg,#22c55e,#16a34a);
    color:#fff;
    padding:48px;
    position:relative;
}

.login-info::before{
    content:"";
    position:absolute;
    inset:0;
    background:
        radial-gradient(circle at top left,rgba(255,255,255,.25),transparent 60%),
        radial-gradient(circle at bottom right,rgba(255,255,255,.2),transparent 60%);
}

.login-info-content{
    position:relative;
    z-index:2;
}

.login-info h2{
    font-size:36px;
    margin-bottom:16px;
}

.login-info p{
    max-width:340px;
    line-height:1.6;
    font-size:15px;
    opacity:.95;
}

/* ===== RESPONSIVE ===== */
@media(max-width:900px){
    .login-wrapper{
        flex-direction:column;
    }
    .login-form,
    .login-info{
        width:100%;
    }
    .login-info{
        min-height:200px;
    }
}
</style>
</head>
<body>

<div class="login-wrapper">

    <!-- LEFT -->
    <div class="login-form">
        <h1>Hello!</h1>
        <p>Sign in to your account</p>

        <form method="POST"
              action="/SISTEM-iso/public/index.php?controller=Auth&action=auth">

            <div class="form-group">
                <div class="input-wrapper">
                    <span class="icon">📧</span>
                    <input type="text" name="username" placeholder="Username" required>
                </div>
            </div>

            <div class="form-group">
                <div class="input-wrapper">
                    <span class="icon">🔒</span>
                    <input type="password" name="password" placeholder="Password" required>
                </div>
            </div>

            <div class="form-extra">
                <label>
                    <input type="checkbox"> Remember me
                </label>
                <a href="#">Forgot password?</a>
            </div>

            <button type="submit">SIGN IN</button>

            <div class="register">
                Don't have an account? <a href="#">Create</a>
            </div>

        </form>
    </div>

    <!-- RIGHT -->
    <div class="login-info">
        <div class="login-info-content">
            <h2>Welcome Back!</h2>
            <p>
                ISO HR Management System membantu pengelolaan data karyawan,
                akses role, dan kontrol sistem secara aman dan terpusat.
            </p>
        </div>
    </div>

</div>

</body>
</html>
