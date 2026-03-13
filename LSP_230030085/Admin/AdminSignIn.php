<?php
session_start();
include "../Center/Connect.php"; 

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password']; 

    // Query untuk validasi kredensial admin
    $query = mysqli_query($con, "SELECT * FROM admin WHERE email='$email' AND password='$password'");

    // Jika data ditemukan
    if (mysqli_num_rows($query) > 0) {
        // Menyimpan email admin ke dalam session untuk proteksi halaman admin
        $_SESSION['admin'] = $email;
        // Mengarahkan admin ke halaman dashboard stok
        header("Location: AdminStock.php");
    } else {
        // Jika tidak valid = pesan error
        $error = "Email atau Password salah!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login - Boyaen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #4A2B0F; display: flex; align-items: center; justify-content: center; height: 100vh; }
        .login-card { background: white; padding: 40px; border-radius: 20px; width: 100%; max-width: 400px; box-shadow: 0 10px 25px rgba(0,0,0,0.3); }
        .btn-admin { background: #6B9A2D; color: white; border: none; }
        .btn-admin:hover { background: #5a8226; color: white; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="text-center mb-4">
            <img src="../Asset/logo.png" height="60">
            <h4 class="mt-3 fw-bold">Admin Sign In</h4>
        </div>
        <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
        <form method="POST">
            <div class="mb-3">
                <label>Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="" required>
            </div>
            <button type="submit" name="login" class="btn btn-admin w-100 py-2">Login Sekarang</button>
        </form>
    </div>
</body>
</html>