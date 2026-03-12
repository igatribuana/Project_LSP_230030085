<?php
namespace Boyaen\App;

interface BarangInterface {
    public function getInfo();
}

// Class Induk (Parent Class)
class ProdukBase {
    public $nama;
    public $harga;

    public function __construct($nama, $harga) {
        $this->nama = $nama;
        $this->harga = $harga;
    }
}

// Konsep Inheritance (Pewarisan) - Produk mewarisi ProdukBase
class Produk extends ProdukBase implements BarangInterface {
    public function getInfo() {
        return "Produk: " . $this->nama . " - Harga: " . $this->harga;
    }
}
?>