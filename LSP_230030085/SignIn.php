<?php
session_start();
include "Center/Connect.php"; 

$error = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query untuk mencocokkan data yang diinput
    $query = "SELECT * FROM user WHERE email='$email' AND password='$password'";
    $result = mysqli_query($con, $query);
    $data = mysqli_fetch_assoc($result);

    // Jika ada = arahkan ke home
    if ($data) {
        $_SESSION['username'] = $data['username'];
        header("Location: Home.php"); 
        exit();
    } else {
        // Jika tidak = error
        $error = "Email atau Password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Sign In - Boyaen Pet Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body { 
            background: #6B9A2D; 
        }
        .bg-boyaen { 
            background: #4A2B0F !important; 
            color: white !important;
        }
        .text-boyaen { 
            color: #4A2B0F !important; 
        }
    </style>
</head>

<body class="vh-100 d-flex align-items-center justify-content-center">

    <div class="card p-4 shadow-lg border-0 text-center" style="width: 22rem; border-radius: 20px;">
        
        <div class="card-body">
            <img src="Asset/logo.png" alt="Logo" class="mb-3" style="width: 120px;">
            <h2 class="fw-bold text-boyaen mb-4">Sign In</h2>
            
            <?php if($error) : ?>
                <div class="alert alert-danger py-2" style="font-size: 13px;">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="mb-3 text-start">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>
                
                <div class="mb-4 text-start">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                
                <button type="submit" class="btn bg-boyaen w-100 fw-bold py-2 mb-3 shadow-sm">
                    Sign In
                </button>
            </form>

            <p class="mb-0 text-muted" style="font-size: 14px;">
                Belum punya akun? <a href="SignUp.php" class="text-boyaen fw-bold text-decoration-none">Sign Up</a>
            </p>
        </div>

    </div>

</body>
</html>