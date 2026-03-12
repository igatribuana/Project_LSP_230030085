<?php
session_start();
include "Center/Connect.php"; 

// ambil data
$query = "SELECT cart.id_cart, cart.id_product, product.nama_product, product.harga, cart.jumlah 
          FROM cart 
          JOIN product ON cart.id_product = product.id_product";
$result = mysqli_query($con, $query);

$cart_items = [];
$grand_total = 0;

// proses data
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $cart_items[] = $row; 

        $id_p = $row['id_product'];
        $qty_beli = $row['jumlah'];

        // update stok
        $update_stok = "UPDATE product SET stock = stock - $qty_beli WHERE id_product = '$id_p'";
        mysqli_query($con, $update_stok);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Invoice - Boyaen Pet Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Courier New', Courier, monospace; padding: 20px; color: #333; }
        .invoice-box { max-width: 600px; margin: auto; border: 1px solid #eee; padding: 30px; }
        .header { text-align: center; border-bottom: 2px dashed #4A2B0F; padding-bottom: 10px; }
        .info { margin: 20px 0; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; border-bottom: 1px solid #ddd; }
        td { padding: 10px 0; }
        .total { font-size: 18px; font-weight: bold; text-align: right; margin-top: 20px; }
        .footer { text-align: center; margin-top: 50px; font-size: 12px; }
        
        /* Tombol Cetak Hilang saat PDF di-print */
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>

<div class="invoice-box">
    <div class="header">
        <h1>BOYAEN PET SHOP</h1>
        <p>Jl. Gunung Tangkuban Perahu No.68, Denpasar</p>
    </div>

    <div class="info">
        <p>No. Invoice: #INV-<?php echo date('Ymd'); ?>-<?php echo rand(10,99); ?></p>
        <p>Tanggal: <?php echo date('d F Y'); ?></p>
        <p>Customer: <?php echo $_SESSION['username']; ?></p>
    </div>

    <table>
        <tr>
            <th>Produk</th>
            <th>Qty</th>
            <th>Total</th>
        </tr>
        <?php foreach ($cart_items as $item) : 
            $subtotal = $item['harga'] * $item['jumlah'];
            $grand_total += $subtotal;
        ?>
        <tr>
            <td><?php echo $item['nama_product']; ?></td>
            <td><?php echo $item['jumlah']; ?></td>
            <td>Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <div class="total">
        Grand Total: Rp <?php echo number_format($grand_total, 0, ',', '.'); ?>
    </div>

    <div class="footer">
        <p>Terima kasih telah berbelanja!</p>
        <p>Simpan invoice ini sebagai bukti pembayaran sah.</p>
    </div>
</div>

<div class="no-print" style="text-align:center; margin-top: 20px;">
    <button onclick="window.print()" style="padding:10px 20px; background:#6B9A2D; color:white; border:none; border-radius:5px; cursor:pointer;">
        Simpan sebagai PDF / Cetak
    </button>
    <a href="Home.php" style="margin-left:10px; text-decoration:none; color:#4A2B0F;">Kembali ke Beranda</a>
</div>

</body>
</html>