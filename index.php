<?php include 'navbar.php'; ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Politeknik Mitra Karya Mandiri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Carousel / Hero -->
<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="img/foto_login.jpg" class="d-block w-100" style="height: 85vh; object-fit: cover;">
            <div class="carousel-caption bg-dark bg-opacity-50 rounded p-3">
                <h2>Selamat Datang di Politeknik Mitra Karya Mandiri</h2>
                <p>Mari wujudkan masa depan gemilang bersama kami</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="img/foto.jpg" class="d-block w-100" style="height: 85vh; object-fit: cover;">
            <div class="carousel-caption bg-dark bg-opacity-50 rounded p-3">
                <h2>Pendidikan Berkualitas & Tenaga Profesional</h2>
                <p>Kami membentuk generasi yang siap kerja dan berkompeten</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="img/wallpaper key.jpg" class="d-block w-100" style="height: 85vh; object-fit: cover;">
            <div class="carousel-caption bg-dark bg-opacity-50 rounded p-3">
                <h2>Daftar Sekarang!</h2>
                <p>Jadilah bagian dari Politeknik Mitra Karya Mandiri</p>
                <a href="pendaftaran.php" class="btn btn-warning">Daftar Sekarang</a>
            </div>
        </div>
    </div>
</div>

<!-- Tentang Singkat -->
<section class="py-5 text-center">
    <div class="container">
        <h2 class="mb-3">Tentang Kami</h2>
        <p class="mb-3">Politeknik Mitra Karya Mandiri berkomitmen mencetak lulusan yang unggul di bidang teknologi dan manajemen.</p>
        <a href="tentang.php" class="btn btn-outline-warning">Selengkapnya</a>
    </div>
</section>

<!-- Pendaftaran Singkat -->
<section class="py-5 bg-light text-center">
    <div class="container">
        <h2 class="mb-3">Pendaftaran Mahasiswa Baru</h2>
        <p class="mb-3">Segera daftarkan diri Anda untuk bergabung bersama kami dan raih masa depan cerah.</p>
        <a href="pendaftaran.php" class="btn btn-warning">Daftar Sekarang</a>
    </div>
</section>

<!-- Kontak Singkat -->
<section class="py-5 text-center">
    <div class="container">
        <h2 class="mb-3">Hubungi Kami</h2>
        <p class="mb-3">Butuh bantuan atau informasi lebih lanjut? Silakan hubungi kami.</p>
        <a href="kontak.php" class="btn btn-outline-warning">Hubungi Kami</a>
    </div>
</section>

<!-- Footer -->
<footer class="text-center text-white py-3" style="background-color: #ff9800;">
    <p class="mb-0">© 2025 Politeknik Mitra Karya Mandiri. All Rights Reserved.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
