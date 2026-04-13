<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portofolio | <?= isset($page_title) ? $page_title : 'Website' ?></title>
    <!-- Menghubungkan CSS -->
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
    <!-- Mulai area utama -->
    <main class="container">
