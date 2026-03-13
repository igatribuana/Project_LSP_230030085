<?php
include "Center/Connect.php"; 

$message = "";

// Mengecek apakah ada data yang dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari input form dan menyimpannya ke dalam variabel
    $username = $_POST['username'];
    $email    = $_POST['email'];
    $password = $_POST['password'];

    // Query memasukkan data ke tabel user
    $query = "INSERT INTO user (username, email, password) VALUES ('$username', '$email', '$password')";
    
    //  Jika berhasil = diarahkan ke Sign In
    if (mysqli_query($con, $query)) {
        header("Location: SignIn.php");
        exit();
    } else {
        // Jika gagal = coba lagi
        $message = "Pendaftaran gagal, silakan coba lagi.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Sign Up - Boyaen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body { background: #6B9A2D; }
        .bg-cokelat { background: #4A2B0F !important; color: white; }
        .text-cokelat { color: #4A2B0F; }
    </style>
</head>

<body class="d-flex align-items-center justify-content-center vh-100">

    <div class="card p-4 shadow-lg border-0 text-center" style="width: 22rem; border-radius: 15px;">
        
        <img src="Asset/logo.png" class="mx-auto mb-3" style="width: 100px;">
        <h2 class="fw-bold text-cokelat">Sign Up</h2>

        <?php if($message) echo "<div class='alert alert-danger py-1 mt-2' style='font-size:12px;'>$message</div>"; ?>

        <form action="" method="POST" class="mt-3">
            <input type="text" name="username" class="form-control mb-3" placeholder="Username" required>
            <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>
            <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
            
            <button type="submit" class="btn bg-cokelat w-100 fw-bold py-2">Sign Up</button>
        </form>

        <p class="mt-3 text-start mb-0" style="font-size: 13px;">
            Sudah punya akun? <a href="SignIn.php" class="text-cokelat fw-bold text-decoration-none">Sign In</a>
        </p>
    </div>

</body>
</html>