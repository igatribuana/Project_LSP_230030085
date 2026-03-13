<?php
session_start(); // Memulai session

// Menghapus semua data session
session_unset();
session_destroy();

// Redirect otomatis ke login
header("Location: SignIn.php");
exit();
?>