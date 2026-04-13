<?php
// Menentukan halaman yang akan dimuat, default adalah 'home'
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Daftar halaman yang diperbolehkan untuk keamanan (Whitelisting)
$allowed_pages = ['home', 'about', 'works', 'contact'];

// Validasi halaman, jika tidak ada di daftar maka kembali ke 'home'
if (!in_array($page, $allowed_pages)) {
    $page = 'home';
}

// Menyiapkan judul halaman agar dinamis
$titles = [
    'home' => 'Beranda',
    'about' => 'Tentang Saya',
    'works' => 'Portofolio',
    'contact' => 'Hubungi Saya'
];
$page_title = $titles[$page];

// Memuat Header
include 'includes/header.php';

// Route: Memuat konten halaman sesuai permintaan
$page_path = "pages/{$page}.php";
if (file_exists($page_path)) {
    include $page_path;
} else {
    echo "<h2>Halaman tidak ditemukan!</h2>";
}

// Memuat Footer
include 'includes/footer.php';
?>
