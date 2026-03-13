<?php
// Alamat virtual code
namespace Boyaen\Admin;

// Interface
interface BarangInterface {
    public function getInfo();
}

// Class Induk
class Produk {
    // Properties
    public $nama;  
    
    // Overloading
    public function __construct($nama) {
        $this->nama = $nama;
    }
}

// Inheritance: Pewarisan 
class DetailProduk extends Produk implements BarangInterface {
    public function getInfo() {
        return "Nama Barang: " . $this->nama;
    }
}

session_start();
include "../Center/Connect.php"; 

if (!isset($_SESSION['admin'])) {
    header("Location: AdminSignIn.php");
    exit();
}

$products = mysqli_query($con, "SELECT * FROM product");

if (!$products) {
    die("Query Error: " . mysqli_error($con));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Monitoring Stok - Boyaen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sidebar { height: 100vh; width: 250px; position: fixed; background: #4A2B0F; color: white; padding: 20px; }
        .content { margin-left: 260px; padding: 30px; }
        .nav-link { color: rgba(255,255,255,0.7); margin-bottom: 10px; }
        .nav-link.active { color: white; font-weight: bold; background: #6B9A2D; border-radius: 8px; }
        .badge-low { background-color: #ffc107; color: #000; } /* Untuk stok menipis */
    </style>
</head>
<body>
    <div class="sidebar">
        <h4 class="fw-bold mb-4">Boyaen Admin</h4>
        <a href="AdminStock.php" class="nav-link active p-2 d-block">Stok Produk</a>
        <a href="AdminCRUD.php" class="nav-link p-2 d-block">Kelola Produk</a>
        <hr>
        <a href="AdminSignIn.php" class="text-white text-decoration-none">Logout</a>
    </div>

    <div class="content">
        <h2 class="mb-4">Monitoring Persediaan Barang</h2>
        
        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Produk</th>
                            <th class="text-center">Sisa Stok</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($p = mysqli_fetch_assoc($products)) : ?>
                        <tr>
                            <td><strong><?= $p['nama_product'] ?></strong></td>
                            <td class="text-center">
                                <?= $p['stock'] ?>
                            </td>
                            <td class="text-center">
                                <?php if($p['stock'] <= 5): ?>
                                    <span class="badge badge-low">Stok Hampir Habis!</span>
                                <?php else: ?>
                                    <span class="badge bg-success">Aman</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>