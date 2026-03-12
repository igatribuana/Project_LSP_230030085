<?php
session_start();
include "Center/Connect.php"; 
include 'Center/Models.php';

// ubah jumlah pembelian
if (isset($_POST['update_jumlah'])) {
    $id_cart = $_POST['id_cart'];
    $aksi = $_POST['aksi'];
    
    if ($aksi == 'tambah') {
        mysqli_query($con, "UPDATE cart SET jumlah = jumlah + 1 WHERE id_cart = '$id_cart'");
    } elseif ($aksi == 'kurang') {
        // Cek agar jumlah tidak kurang dari 1
        $cek = mysqli_query($con, "SELECT jumlah FROM cart WHERE id_cart = '$id_cart'");
        $data = mysqli_fetch_assoc($cek);
        if ($data['jumlah'] > 1) {
            mysqli_query($con, "UPDATE cart SET jumlah = jumlah - 1 WHERE id_cart = '$id_cart'");
        }
    }
    header("Location: Cart.php");
    exit();
}

// tambah produk ke keranjang
if (isset($_POST['add_to_cart'])) {
    $id_product = $_POST['id_product'];
    $cek_cart = mysqli_query($con, "SELECT * FROM cart WHERE id_product = '$id_product'");
    if (mysqli_num_rows($cek_cart) > 0) {
        mysqli_query($con, "UPDATE cart SET jumlah = jumlah + 1 WHERE id_product = '$id_product'");
    } else {
        mysqli_query($con, "INSERT INTO cart (id_product, jumlah) VALUES ('$id_product', 1)");
    }
    header("Location: Home.php?status=success");
    exit();
}

// fungsi hitung total
function hitungTotal($harga, $jumlah) {
    return $harga * $jumlah;
}

// hapus produk yang tidak jadi dibeli
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($con, "DELETE FROM cart WHERE id_cart = '$id'");
    header("Location: Cart.php");
    exit();
}

// baca pembelian
$query = "SELECT cart.id_cart, product.nama_product, product.harga, cart.jumlah 
          FROM cart 
          JOIN product ON cart.id_product = product.id_product";
$result = mysqli_query($con, $query);

$cart_items = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $cart_items[] = $row;
    }
}
$grand_total = 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Keranjang Belanja - Boyaen Pet Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{ background:#6B9A2D; min-height: 100vh; padding-top: 100px; }
        .navbar{ background:white; padding:10px 60px; box-shadow:0 2px 15px rgba(0,0,0,0.15); width: 100%; position: fixed; top: 0; z-index: 1000; }
        .cart-container{ background:white; padding:30px; border-radius:15px; width:90%; max-width: 900px; margin: 0 auto; box-shadow:0 5px 15px rgba(0,0,0,0.2); }
        th{ background:#4A2B0F !important; color:white !important; }
        .btn-qty { padding: 0px 10px; font-weight: bold; }
    </style>
</head>
<body>

<div class="navbar d-flex justify-content-between align-items-center">
    <a href="Home.php"><img src="Asset/logo.png" height="50"></a>
    <div class="menu">
        <a href="Home.php" class="btn btn-outline-dark btn-sm me-2">Kembali Belanja</a>
        <a href="UserPage.php"><img src="Asset/usericon.png" height="40"></a>
    </div>
</div>

<div class="cart-container">
    <h1 class="text-center mb-4" style="color: #4A2B0F;">Keranjang Belanja</h1>
    <table class="table table-hover">
        <thead>
            <tr class="text-center">
                <th>Produk</th>
                <th>Harga</th>
                <th width="150">Jumlah</th>
                <th>Total</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($cart_items) > 0) : ?>
                <?php foreach ($cart_items as $item) : 
                    $subtotal = hitungTotal($item['harga'], $item['jumlah']);
                    $grand_total += $subtotal;
                ?>
                <tr class="align-middle text-center">
                    <td><?php echo $item['nama_product']; ?></td>
                    <td>Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?></td>
                    
                    <td>
                        <form action="Cart.php" method="POST" class="d-flex justify-content-center align-items-center gap-2">
                            <input type="hidden" name="id_cart" value="<?php echo $item['id_cart']; ?>">
                            
                            <button type="submit" name="update_jumlah" value="1" class="btn btn-sm btn-outline-danger btn-qty" 
                                    onclick="this.form.aksi.value='kurang'">-</button>
                            
                            <span class="fw-bold px-2"><?php echo $item['jumlah']; ?></span>
                            
                            <button type="submit" name="update_jumlah" value="1" class="btn btn-sm btn-outline-success btn-qty" 
                                    onclick="this.form.aksi.value='tambah'">+</button>
                            
                            <input type="hidden" name="aksi" value="">
                        </form>
                    </td>
                    
                    <td class="fw-bold text-success">Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></td>
                    <td>
                        <a href="Cart.php?hapus=<?php echo $item['id_cart']; ?>" 
                           class="btn btn-danger btn-sm" onclick="return confirm('Hapus item ini?')">Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="5" class="text-center py-5 text-muted">Keranjang belanja kamu masih kosong.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="total-section text-end mt-4 pt-3 border-top">
    <h2 class="mb-3">Total: <span class="text-success">Rp <?php echo number_format($grand_total, 0, ',', '.'); ?></span></h2>
    
    <a href="Invoice.php" class="btn btn-lg btn-dark px-5 py-3 shadow text-decoration-none" 
       style="background: #4A2B0F; color: white;">
       Checkout Sekarang
    </a>
</div>
</div>

</body>
</html>