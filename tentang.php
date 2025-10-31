<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami | Politeknik Mitra Karya Mandiri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="img/logo_mkm.png" type="image/x-icon">
</head>
<?php include 'includes/navbar.php'; ?>

<body>

    <!-- Hero Section -->
    <section class="position-relative text-white text-center" style="height: 70vh;">
        <img src="img/tentang2.jpg" class="w-100 h-100 position-absolute top-0 start-0" style="object-fit: cover;"
            alt="Kampus MKM">
        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50"></div>
        <div class="position-relative d-flex flex-column justify-content-center align-items-center h-100">
            <h1 class="fw-bold">Tentang Politeknik Mitra Karya Mandiri</h1>
            <p class="lead">Menjadi Institusi Vokasi Unggul yang Mempersiapkan Lulusan Siap Kerja dan Profesional</p>
        </div>
    </section>

    <!-- Profil Singkat -->
    <section class="py-5">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-md-6">
                    <img src="img/tentang1.jpg" alt="Tentang Kampus" class="img-fluid rounded shadow">
                </div>
                <div class="col-md-6">
                    <h2 class="mb-3 text-warning">Profil Politeknik MKM</h2>
                    <p>
                        Politeknik Mitra Karya Mandiri Ketanggungan Brebes merupakan lembaga pendidikan vokasi
                        yang berfokus pada pengembangan keterampilan praktis, inovatif, dan siap kerja.
                        Dengan dukungan tenaga pendidik profesional serta fasilitas yang memadai,
                        kami berkomitmen untuk mencetak lulusan yang kompeten dan berdaya saing tinggi.
                    </p>
                    <p>
                        Kurikulum kami dirancang sesuai kebutuhan dunia industri dan dunia kerja (IDUKA),
                        sehingga mahasiswa tidak hanya memperoleh teori, tetapi juga pengalaman praktik langsung.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Visi & Misi -->
    <section class="py-5 bg-light">
        <div class="container text-center">
            <h2 class="mb-4 text-warning">Visi & Misi</h2>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <h4 class="text-dark fw-bold">Visi</h4>
                    <p class="mb-4">Menjadi Politeknik unggul dan berdaya saing di tingkat nasional dalam bidang
                        teknologi dan manajemen.</p>

                    <h4 class="text-dark fw-bold">Misi</h4>
                    <ul class="list-unstyled">
                        <li>• Menyelenggarakan pendidikan vokasi berkualitas berbasis kompetensi.</li>
                        <li>• Mengembangkan riset terapan untuk mendukung kemajuan industri dan masyarakat.</li>
                        <li>• Meningkatkan kerja sama dengan dunia usaha, dunia industri, dan lembaga pemerintahan.</li>
                        <li>• Membangun karakter mahasiswa yang berintegritas, kreatif, dan mandiri.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Fasilitas -->
    <section class="py-5">
        <div class="container text-center">
            <h2 class="mb-4 text-warning">Fasilitas Kampus</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <img src="img/labkom.jpg" class="card-img-top" alt="Lab Komputer">
                        <div class="card-body">
                            <h5 class="card-title text-dark fw-bold">Laboratorium Komputer</h5>
                            <p class="card-text">Dilengkapi dengan perangkat terbaru untuk mendukung pembelajaran
                                berbasis teknologi.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <img src="img/farmasi.jpg" class="card-img-top" alt="Perpustakaan">
                        <div class="card-body">
                            <h5 class="card-title text-dark fw-bold">Perpustakaan Modern</h5>
                            <p class="card-text">Tersedia berbagai referensi akademik, jurnal, dan e-book untuk
                                menunjang studi mahasiswa.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <img src="img/tlm.jpg" class="card-img-top" alt="Ruang Kelas">
                        <div class="card-body">
                            <h5 class="card-title text-dark fw-bold">Ruang Kelas Nyaman</h5>
                            <p class="card-text">Ruang belajar ber-AC dan multimedia untuk menciptakan suasana belajar
                                yang kondusif.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-5 bg-warning text-center text-white">
        <div class="container">
            <h2 class="mb-3">Bergabunglah Bersama Kami!</h2>
            <p>Segera daftarkan diri Anda dan raih masa depan cerah bersama Politeknik Mitra Karya Mandiri.</p>
            <a href="pendaftaran.php" class="btn btn-light fw-bold">Daftar Sekarang</a>
        </div>
    </section>
    <?php include 'includes/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>