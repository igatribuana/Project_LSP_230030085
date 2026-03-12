<?php
session_start(); // Memulai session agar bisa dihapus

// Menghapus semua data session
session_unset();
session_destroy();

// Redirect otomatis ke halaman login
header("Location: SignIn.php");
exit();
?>