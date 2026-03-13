<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "petshop"; 

// Membuat koneksi ke server database
$con = mysqli_connect($host, $user, $pass, $db);

// Mengecek apakah koneksi berhasil atau gagal
if (!$con) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>