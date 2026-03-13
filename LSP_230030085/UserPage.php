<?php
session_start();
include "Center/Connect.php"; 

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: SignIn.php");
    exit();
}

// Ambil data user yang sedang login
$user_login = $_SESSION['username'];
$query = "SELECT * FROM user WHERE username = '$user_login'";
$result = mysqli_query($con, $query);
$data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Profile - Boyaen Pet Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        *{
            font-family: Arial, Helvetica, sans-serif;
            margin:0;
            padding:0;
            box-sizing:border-box;
        }
        body{
            background:linear-gradient(135deg,#6B9A2D,#7fb33a);
            min-height: 100vh;
        }
        /* NAVBAR */
        .navbar{
            display:flex;
            justify-content:space-between;
            align-items:center;
            background:white;
            padding:15px 60px;
            box-shadow:0 2px 15px rgba(0,0,0,0.15);
        }
        .logo img{ height:90px; }
        .menu { display: flex; align-items: center; gap: 15px; }

        /* PROFILE CARD */
        .profile-container{
            display:flex;
            justify-content:center;
            align-items:center;
            height:80vh;
        }
        .profile-card{
            background:white;
            padding:40px;
            border-radius:20px;
            text-align:center;
            width:350px;
            box-shadow:0 8px 20px rgba(0,0,0,0.2);
        }

        /* ICON USER */
        .profile-icon-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 15px;
            border: 3px solid #6B9A2D;
            padding: 5px;
        }

        .profile-card h2{
            color:#4A2B0F;
            margin-bottom:5px;
        }
        .profile-card p{
            color:#666;
            margin-bottom:20px;
        }

        /* BUTTON */
        .profile-button button{
            width:100%;
            padding:12px;
            margin:8px 0;
            border:none;
            border-radius:8px;
            cursor:pointer;
            font-weight:bold;
            transition: 0.3s;
        }
        .edit-btn{
            background:#6B9A2D;
            color:white;
        }
        .edit-btn:hover{ background: #557c23; }

        .logout-btn{
            background:#4A2B0F;
            color:white;
        }
        .logout-btn:hover{ background: #3a210c; }

        .profile-button a {
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="navbar">
    <div class="logo">
        <a href="Home.php"><img src="Asset/logo.png" height="40"></a>
    </div>
    <div class="menu">
        <a href="Cart.php"><img src="Asset/carticon.png" height="50" alt="Cart"></a>
        <a href="UserPage.php"><img src="Asset/usericon.png" height="50" alt="User"></a>
    </div>
</div>

<div class="profile-container">
    <div class="profile-card">
        <img src="Asset/usericon.png" alt="User Icon" class="profile-icon-img">
        
        <h2><?php echo $data['username']; ?></h2>
        <p><?php echo $data['email']; ?></p>

        <div class="profile-button">
            <a href="Logout.php">
                <button class="logout-btn">Logout</button>
            </a>
        </div>
    </div>
</div>

</body>
</html>