<?php
// Alamat virtual code
namespace Boyaen\Admin;

session_start();
include "../Center/Connect.php"; 

if (!isset($_SESSION['admin'])) header("Location: AdminSignIn.php");

// tambah produk
if (isset($_POST['add'])) {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $stock = $_POST['stock'];
    $desc = $_POST['deskripsi'];
    $gambar = $_POST['gambar']; 

    mysqli_query($con, "INSERT INTO product (nama_product, harga, stock, deskripsi, gambar) VALUES ('$nama', '$harga', '$stock', '$desc', '$gambar')");
    header("Location: AdminCRUD.php");
}

// hapus produk
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($con, "DELETE FROM product WHERE id_product='$id'");
    header("Location: AdminCRUD.php");
}

// update stok
if (isset($_POST['update_stok_cepat'])) {
    $id_p = $_POST['id_product'];
    $aksi = $_POST['aksi'];
    
    if ($aksi == 'tambah') {
        mysqli_query($con, "UPDATE product SET stock = stock + 1 WHERE id_product = '$id_p'");
    } elseif ($aksi == 'kurang') {
        // Cek agar stok tidak minus (paling kecil 0)
        $cek = mysqli_query($con, "SELECT stock FROM product WHERE id_product = '$id_p'");
        $data = mysqli_fetch_assoc($cek);
        if ($data['stock'] > 0) {
            mysqli_query($con, "UPDATE product SET stock = stock - 1 WHERE id_product = '$id_p'");
        }
    }
    header("Location: AdminCRUD.php");
    exit();
}

$products = mysqli_query($con, "SELECT * FROM product");
?>
<!DOCTYPE html>
<html>
<head>
    <title>CRUD Produk - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sidebar { height: 100vh; width: 250px; position: fixed; background: #4A2B0F; color: white; padding: 20px; }
        .content { margin-left: 260px; padding: 30px; }
        .nav-link { color: rgba(255,255,255,0.7); margin-bottom: 10px; }
        .nav-link.active { color: white; font-weight: bold; background: #6B9A2D; border-radius: 8px; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h4 class="fw-bold mb-4">Boyaen Admin</h4>
        <a href="AdminStock.php" class="nav-link p-2 d-block">Stok Produk</a>
        <a href="AdminCRUD.php" class="nav-link active p-2 d-block">Kelola Produk</a>
        <hr>
        <a href="AdminSignIn.php" class="text-white text-decoration-none">Logout</a>
    </div>

    <div class="content">
        <div class="d-flex justify-content-between mb-4">
            <h2>Daftar Management Produk</h2>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal">+ Tambah Produk</button>
        </div>

        <table class="table table-bordered bg-white shadow-sm">
            <thead class="table-dark">
                <tr>
                    <th>Gambar</th>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while($p = mysqli_fetch_assoc($products)) : ?>
                <tr class="align-middle">
                    <td><img src="../Asset/<?= $p['gambar'] ?>" width="50"></td>
                    <td><?= $p['nama_product'] ?></td>
                    <td>Rp <?= number_format($p['harga'], 0, ',', '.') ?></td>
        
                    <td>
                        <form action="AdminCRUD.php" method="POST" class="d-flex align-items-center gap-2">
                            <input type="hidden" name="id_product" value="<?= $p['id_product'] ?>">
                            <input type="hidden" name="aksi" value="">

                            <button type="submit" name="update_stok_cepat" class="btn btn-sm btn-outline-danger" 
                                onclick="this.form.aksi.value='kurang'">-</button>
                
                            <span class="fw-bold" style="min-width: 30px; text-align: center;"><?= $p['stock'] ?></span>
                
                            <button type="submit" name="update_stok_cepat" class="btn btn-sm btn-outline-success" 
                                onclick="this.form.aksi.value='tambah'">+</button>
                        </form>
                    </td>

                    <td>
                        <a href="AdminCRUD.php?hapus=<?= $p['id_product'] ?>" class="btn btn-danger btn-sm" 
                            onclick="return confirm('Hapus produk ini?')">Hapus</a>
                    </td>
    </tr>
    <?php endwhile; ?>
</tbody>
        </table>
    </div>

    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content" method="POST">
                <div class="modal-header"><h5>Tambah Produk Baru</h5></div>
                <div class="modal-body">
                    <input type="text" name="nama" placeholder="Nama Produk" class="form-control mb-2" required>
                    <input type="number" name="harga" placeholder="Harga" class="form-control mb-2" required>
                    <input type="number" name="stock" placeholder="Stok Awal" class="form-control mb-2" required>
                    <input type="text" name="gambar" placeholder="Nama File Gambar (ex: kibul.jpg)" class="form-control mb-2" required>
                    <textarea name="deskripsi" placeholder="Deskripsi Singkat" class="form-control" required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="add" class="btn btn-primary">Simpan Produk</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>