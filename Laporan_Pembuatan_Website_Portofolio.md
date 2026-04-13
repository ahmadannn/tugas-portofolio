<div align="center">

# TUGAS
## Aplikasi Berbasis Platform

<br><br><br>

**Disusun oleh:**<br>
Ahmadan Syaridin<br>
2311102038<br>
S1 IF-11-REG04<br>

<br><br>

**Dosen Pengampu:**<br>
Cahyo Prihantoro, S.Kom., M.Eng<br>

<br><br><br>

**PROGRAM STUDI S1 INFORMATIKA**<br>
**FAKULTAS INFORMATIKA**<br>
**TELKOM UNIVERSITY**<br>
**2026/2027**<br>

</div>

<div style="page-break-after: always;"></div>

## SOAL
Bikin website pilih salah satu tema dari website lamar kerja, cv atau portofolio.
Tugas 1 wajib menggunakan native html, CSS, php, ajax, js.

---

## Link GIT
**[Masukkan Link Repository GitHub/GitLab Anda Di Sini]**

---

## Source Code

Berikut adalah keseluruhan struktur direktori dan kode sumber (source code) yang membangun aplikasi portofolio:

### 1. File Entry-Point `index.php`
```php
<?php
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$allowed_pages = ['home', 'about', 'works', 'contact'];

if (!in_array($page, $allowed_pages)) {
    $page = 'home';
}

$titles = [
    'home' => 'Beranda',
    'about' => 'Tentang Saya',
    'works' => 'Portofolio',
    'contact' => 'Hubungi Saya'
];
$page_title = $titles[$page];

include 'includes/header.php';

$page_path = "pages/{$page}.php";
if (file_exists($page_path)) {
    include $page_path;
} else {
    echo "<h2>Halaman tidak ditemukan!</h2>";
}

include 'includes/footer.php';
?>
```

### 2. Komponen `includes/header.php`
```php
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portofolio | <?= isset($page_title) ? $page_title : 'Website' ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <a href="index.php?page=home">MyPortofolio</a>
            </div>
            <ul class="nav-links">
                <li><a href="index.php?page=home" class="<?= ($page == 'home') ? 'active' : '' ?>">Beranda</a></li>
                <li><a href="index.php?page=about" class="<?= ($page == 'about') ? 'active' : '' ?>">Tentang</a></li>
                <li><a href="index.php?page=works" class="<?= ($page == 'works') ? 'active' : '' ?>">Portofolio</a></li>
                <li><a href="index.php?page=contact" class="<?= ($page == 'contact') ? 'active' : '' ?>">Kontak</a></li>
            </ul>
        </nav>
    </header>
    <main class="container">
```

### 3. Komponen Konfigurasi Tampilan `assets/css/style.css` *(Cuplikan Utama)*
```css
/* Menggunakan layout Flexbox untuk memastikan halaman adaptif dan ditengah */
body {
    font-family: 'Outfit', sans-serif;
    line-height: 1.6;
    background-color: #0f172a;
    color: #f8fafc;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}
/* Efek Glassmorphism transparan pada Navbar */
header {
    background: rgba(15, 23, 42, 0.6);
    backdrop-filter: blur(12px);
    position: sticky;
    top: 0;
    z-index: 1000;
}
/* Penerapan CSS Grid untuk penyusunan halaman list card portofolio */
.portfolio-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
}
```

### 4. Komponen Halaman Kontak `pages/contact.php`
```html
<section class="page-section animate-fade-in">
    <div class="content-wrapper">
        <h2 class="section-title">Hubungi <span class="highlight">Saya</span></h2>
        
        <div class="contact-container">
            <form id="contact-form">
                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <!-- ... elemen email & pesan ... -->
                <button type="submit" class="btn" id="submit-btn" style="width: 100%;">Kirim Pesan</button>
                <div id="form-notification" class="hidden"></div>
            </form>
        </div>
    </div>
</section>
```

### 5. Skrip AJAX Fetch `assets/js/script.js`
```javascript
document.addEventListener("DOMContentLoaded", () => {
    const contactForm = document.getElementById("contact-form");
    const submitBtn = document.getElementById("submit-btn");
    const notification = document.getElementById("form-notification");

    if (contactForm) {
        contactForm.addEventListener("submit", async function(e) {
            e.preventDefault(); 
            submitBtn.innerText = "Mengirim...";
            
            try {
                const formData = new FormData(this);
                const response = await fetch('api/process_contact.php', {
                    method: 'POST',
                    body: formData
                });
                const data = await response.json();
                
                notification.className = data.status === 'success' ? 'notif-success' : 'notif-error';
                notification.innerText = data.message;
            } catch (error) {
                notification.className = 'notif-error';
                notification.innerText = "Terjadi kesalahan koneksi Backend Server.";
            } finally {
                submitBtn.innerText = "Kirim Pesan";
            }
        });
    }
});
```

### 6. Logic Backend PHP `api/process_contact.php`
```php
<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $message = htmlspecialchars($_POST['message'] ?? '');

    $fileBackupPesan = __DIR__ . '/kumpulan_pesan.txt';
    $isiPesanLog = "Waktu: " . date("Y-m-d H:i:s") . "\nNama Pengirim: $name\nIsi: $message\n\n";

    file_put_contents($fileBackupPesan, $isiPesanLog, FILE_APPEND);

    echo json_encode([
        'status' => 'success',
        'message' => "Hore! Terima kasih {$name}. Pesan telah masuk sistem tanpa reload halaman."
    ]);
}
?>
```

---

## Penjelasan Program

### A. Cara Kerja Per Bagian Secara Utuh
Sistem implementasi dibangun menggunakan konfigurasi **Native Modular PHP**. Arus eksekusi dimulai dan dikendalikan sepenuhnya melalui File Entry-Point `index.php`. 
1. **Penerimaan Parameter (Router):** Saat pengguna berinteraksi di navigasi, parameter dilemparkan melalui metoda GET (contoh: `?page=contact`).
2. **Validasi Whitelist Keamanan:** Skrip secara dinamis mengevaluasi jika paramater tersebut telah didefinisikan ke dalam larik (`array`) `$allowed_pages`. Filter ini memblokir ancaman manipulasi penindihan tautan pada direktori (*Local File Inclusion Exploitation*).
3. **Penyusunan Blok (*Include*)**: Menggunakan fungsi dasar PHP `include`, arsitektir program meletakkan `header.php` sebagai penutup dokumen awal, menjahit bagian tengah berdasarkan _output page_, dan kemudian menyelesaikan konstruksi elemen dengan menutup format lewat `footer.php`.

### B. Logika Interaktivitas dan Real-Time Preview (JavaScript)
Pendekatan manipulasi DOM dan kontrol alur transfer form dipercayakan kepada skrip asinkron menggunakan teknologi terbaru dari **Fetch API JS (AJAX)**.
- Setelah deteksi pemicu melalui `Event Listener 'submit'`, sistem instan memutus prilaku normal penyerahan (*submission*) yang secara alamiah merespon memuat balik layar menggunakan baris perintah `e.preventDefault()`.
- Modul internal `FormData()` mengekstrak nilai spesifik dari tag *input* sebelum mengalirkan data payload ke rute endpoint backend secara tertutup (_Asynchronous_).
- Skema _Request-Response_ berhasil memproduksi output _Non-Blocking_, yang mana sistem mengubah antarmuka div notifikasi HTML menjadi pesan umpan balik dari variabel konversi objek `.json()`.

### C. Sistem Pelaporan dan Penyimpanan Data (PHP & JSON)
Permasalahan pada modul kontak memusat ke file `process_contact.php`. Karena tugas bersifat dasar struktural tanpa dependensi mesin Database Terpusat (contoh: MySQL), manipulasi berkala diaplikasikan lewat manajemen I/O tingkat berkas *(File Manipulation)*.
- **Transmisi Header HTTP:** Penanda instruktif *header* didefinisikan awal mengubah `Content-Type` berkas ke bentuk `application/json` supaya seragam dengan kaidah API.
- **Validasi Mutlak Lanjut:** Parameter yang terbaca melalui inisialisasi Global Array `$_POST` dikenai penyaringan (*sanitation*) ketat instrumen bawaan `htmlspecialchars()` untuk memandulkan fungsi terlarang injeksi tag mematikan (*Cross Site Scripting*).
- **Prosedur Penempelan Log Data (*Appending*)**: Melalui pemicuan logis Native `file_put_contents()`, sistem diperintahkan menciptakan (jika nihil) sebuah dokumen `kumpulan_pesan.txt`, mencampur urutan parameter teks baru dengan urutan waktu spesifik, dan mem-\textit{paste} susunan baru itu dibaris paling akhir.
- **Format Keluaran (*Output Response*)**: Keseluruhan proses yang berhasil dikontrak pada JSON format sebelum skrip melontarkannya ulang (*Echo*) lewat parameter balasan berstatus "success" kepada pendenagr klien Fetch dari bagian *Frontend*.
