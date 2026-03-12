<?php
session_start();
include "Center/Connect.php"; 
include 'Center/Models.php';

function formatRupiah($angka) {
    return "Rp " . number_format($angka, 0, ',', '.');
}

$query = "SELECT * FROM product"; 
$result = mysqli_query($con, $query);
$products = [];
while ($row = mysqli_fetch_assoc($result)) {
    $products[] = $row;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Boyaen Pet Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #6B9A2D; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        
        /* navbar */
        .navbar { background: white !important; box-shadow: 0 2px 15px rgba(0,0,0,0.1); }
        
        /* warna */
        .text-boyaen { color: #4A2B0F !important; }
        .bg-boyaen { background-color: #4A2B0F !important; color: white !important; }
        .btn-boyaen { background: #6B9A2D; color: white; border-radius: 8px; border: none; transition: 0.3s; font-weight: bold; }
        .btn-boyaen:hover { background: #4A2B0F; transform: scale(1.02); }

        .welcome { text-align: center; padding: 60px 20px; color: white; }

        /* css kotak produk */
        .card-produk {
            border: none;
            border-radius: 20px;
            transition: 0.3s;
            box-shadow: 0 6px 15px rgba(0,0,0,0.15);
            padding: 25px !important; /* Membuat kotak lebih luas */
        }
        .card-produk:hover { transform: translateY(-10px); box-shadow: 0 12px 25px rgba(0,0,0,0.3); }
        
        /* css gambar */
        .img-produk-besar {
            height: 250px !important; 
            width: 100%;
            object-fit: contain; 
            margin-bottom: 20px;
        }
        
        .footer { background: #4A2B0F; color: white; padding: 50px 0; margin-top: 50px; }
        .footer img { filter: brightness(0) invert(1); }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand" href="Home.php"><img src="Asset/logo.png" height="60"></a>
        <div class="ms-auto d-flex align-items-center gap-3">
            <span class="user-name fw-bold text-boyaen d-none d-md-inline">Halo, <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest'; ?></span>
            <a href="Cart.php"><img src="Asset/carticon.png" height="40"></a>
            <a href="UserPage.php"><img src="Asset/usericon.png" height="40"></a>
        </div>
    </div>
</nav>

<div class="welcome">
    <h1 class="display-4 fw-bold text-boyaen">Welcome to Boyaen Pet Shop</h1>
    <p class="lead text-boyaen">Temukan kebutuhan terbaik untuk hewan peliharaanmu</p>
</div>

<div class="container mb-5">
    <h2 class="text-center fw-bold text-white mb-2">KATALOG PRODUK</h2>
    <div style="width: 80px; height: 4px; background: #4A2B0F; margin: 0 auto 40px;"></div>

    <div class="row g-4">
        <?php if (count($products) > 0) : ?>
            <?php foreach ($products as $p) : ?>
            <div class="col-12 col-md-6 col-lg-3"> <div class="card h-100 card-produk text-center">
                    <img src="Asset/<?php echo $p['gambar']; ?>" class="img-produk-besar" alt="produk">
                    
                    <div class="card-body d-flex flex-column p-0">
                        <h5 class="card-title fw-bold text-boyaen"><?php echo $p['nama_product']; ?></h5>
                        <p class="card-text small text-muted"><?php echo $p['deskripsi']; ?></p>
                        
                        <div class="mt-auto">
                            <h4 class="fw-bold text-success mb-1"><?php echo formatRupiah($p['harga']); ?></h4>
                            <p class="text-muted small mb-3">Stok: <?php echo $p['stock']; ?></p>
    
                            <form action="Cart.php" method="POST">
                                <input type="hidden" name="id_product" value="<?php echo $p['id_product']; ?>">
                                <input type="hidden" name="nama_product" value="<?php echo $p['nama_product']; ?>">
                                <input type="hidden" name="harga" value="<?php echo $p['harga']; ?>">
                                <input type="hidden" name="gambar" value="<?php echo $p['gambar']; ?>">
        
                            <button type="submit" name="add_to_cart" class="btn btn-boyaen py-2 w-100">+ Keranjang</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="col-12 text-center text-white">Maaf, stok produk sedang kosong.</div>
        <?php endif; ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <div class="row gy-4">
            <div class="col-md-6">
                <h4 class="fw-bold mb-3"><img src="Asset/locationicon.png" height="25" class="me-2">Offline Store</h4>
                <p class="mb-1 small">Jl. Gunung Tangkuban Perahu No. 68</p>
                <p class="mb-1 small">Jl. Imam Bonjol No. 109</p>
                <p class="mb-1 small">Jl. Nuansa Indah Kembang No. 94</p>
            </div>
            <div class="col-md-6">
                <h4 class="fw-bold mb-3">Hubungi Kami</h4>
                <p class="small mb-2"><img src="Asset/phoneicon.png" height="20" class="me-2"> 08123456789</p>
                <p class="small mb-2"><img src="Asset/emailicon.png" height="20" class="me-2"> boyaenpetshop@gmail.com</p>
                <p class="small mb-2"><img src="Asset/webicon.png" height="20" class="me-2"> @boyaenpetshop</p>
            </div>
        </div>
    </div>
</footer>
    <?php if (isset($_GET['status']) && $_GET['status'] == 'success') : ?>
        <script>
            Swal.fire({
                icon: 'success',
                itle: 'Berhasil!',
                text: 'Produk sudah masuk ke keranjang Boyaen.',
                showConfirmButton: false,
                timer: 1500,
                confirmButtonColor: '#6B9A2D'
            });
        </script>
    <?php endif; ?>
</body>
</html>