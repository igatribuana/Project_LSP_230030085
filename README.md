# Boyaen Pet Shop

**"Best quality stuff untuk hewan peliharaan"**

Aplikasi e-commerce sederhana berbasis Web untuk penjualan produk kebutuhan hewan peliharaan, dibangun menggunakan PHP Native dan MySQL.

## Fitur Utama

### Sisi Pelanggan (Customer)
- **Katalog Produk**: Melihat daftar makanan dan kebutuhan hewan secara real-time.
- **Keranjang Belanja**: Menambah, mengurangi jumlah, dan menghapus item pesanan.
- **Sistem Checkout**: Pengurangan stok otomatis saat pembelian berhasil.
- **Invoice PDF**: Cetak bukti transaksi menggunakan fungsi browser print.
- **User Profile**: Autentikasi Login dan Sign-Up untuk pelanggan.

### Sisi Admin (Administrator)
- **Admin Dashboard**: Monitoring stok produk dengan indikator peringatan (stok rendah).
- **Manajemen Produk (CRUD)**: Tambah, edit, dan hapus data produk dari database.
- **Manajemen Stok Cepat**: Tombol pintas untuk update jumlah stok di gudang.

## Teknologi & Konsep Program

- **Backend**: PHP 8.x 
- **Database**: MySQL 
- **Frontend**: HTML5, CSS3, JavaScript.
- **Library Eksternal**: Bootstrap 5 & SweetAlert2.

## Credits
- Aset Gambar & Ikon: Canva Assets Library.

## Struktur Folder 

```text
LSP_230030085/
├── Admin/               # Package halaman admin
│   ├── AdminCRUD.php    # Halaman CRUD produk
│   ├── AdminSignIn.php  # Halaman login admin
│   └── AdminStok.php    # Halaman memantau stok
├── Center/              # Package center (OOP & Database)
│   ├── Connect.php      # Koneksi database
│   └── Models.php       # Class, Interface, & Namespace
├── Asset/               # Media gambar dan icon
├── Home.php             # Halaman utama
├── Cart.php             # Halaman keranjang
├── Invoice.php          # Halaman cetak nota
├── SignIn.php           # Halaman login user
├── SignUp.php           # Halaman regist user
└── README.md            # Dokumentasi