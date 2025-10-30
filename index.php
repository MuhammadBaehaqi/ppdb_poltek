<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Politeknik Mitra Karya Mandiri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="img/logo_mkm.png" type="image/x-icon">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        /* Carousel style */
        .carousel-caption {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(0, 0, 0, 0.55);
            border-radius: 10px;
            padding: 20px 30px;
            width: 70%;
            text-align: center;
        }

        .carousel-caption h2 {
            font-weight: 600;
        }

        .carousel-caption a.btn {
            border: 2px solid #ff9800;
            color: white;
            background-color: transparent;
            transition: 0.3s;
        }

        .carousel-caption a.btn:hover {
            background-color: #ff9800;
            color: white;
        }

        /* Tentang section */
        .tentang-section img {
            border-radius: 15px;
            width: 100%;
            height: auto;
        }

        .tentang-section .text {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* Program Studi */
        .program-card {
            border: none;
            box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .program-card:hover {
            transform: translateY(-5px);
        }

        .program-card .card-title {
            color: #ff9800;
            font-weight: 600;
        }
    </style>
</head>
<?php include 'navbar.php'; ?>

<body>

    <!-- Carousel / Hero -->
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <!-- Slide 1 -->
            <div class="carousel-item active">
                <img src="img/slide1.jpg" class="d-block w-100" style="height: 85vh; object-fit: cover;">
                <div class="carousel-caption">
                    <h2>Selamat Datang di Politeknik Mitra Karya Mandiri</h2>
                    <p>Mari wujudkan masa depan gemilang bersama kami</p>
                    <a href="tentang.php" class="btn btn-outline-warning mt-2">Tentang Kami</a>
                </div>
            </div>
            <!-- Slide 2 -->
            <div class="carousel-item">
                <img src="img/slide2.jpg" class="d-block w-100" style="height: 85vh; object-fit: cover;">
                <div class="carousel-caption">
                    <h2>Pendidikan Berkualitas & Tenaga Profesional</h2>
                    <p>Kami membentuk generasi yang siap kerja dan berkompeten</p>
                    <a href="pendaftaran.php" class="btn btn-outline-warning mt-2">Daftar Sekarang</a>
                </div>
            </div>
            <!-- Slide 3 -->
            <div class="carousel-item">
                <img src="img/slide3.jpg" class="d-block w-100" style="height: 85vh; object-fit: cover;">
                <div class="carousel-caption">
                    <h2>Hubungi Kami</h2>
                    <p>Kami siap membantu Anda mendapatkan informasi terbaik</p>
                    <a href="kontak.php" class="btn btn-outline-warning mt-2">Hubungi Kami</a>
                </div>
            </div>
        </div>

        <!-- Tombol Panah -->
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Sebelumnya</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Selanjutnya</span>
        </button>
    </div>

    <!-- Tentang Singkat -->
    <section class="py-5 tentang-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 mb-4 mb-md-0">
                    <img src="img/tentang1.jpg" alt="Tentang Politeknik">
                </div>
                <div class="col-md-6 text">
                    <h2 class="mb-3">Tentang Kami</h2>
                    <p class="mb-3">
                        Politeknik Mitra Karya Mandiri berkomitmen mencetak lulusan yang unggul,
                        profesional, dan berkarakter di bidang teknologi, kesehatan, dan manajemen.
                    </p>
                    <a href="tentang.php" class="btn btn-outline-warning">Selengkapnya</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Program Studi -->
    <section class="py-5 bg-light">
        <div class="container text-center">
            <h2 class="mb-4">Program Studi Kami</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card program-card">
                        <div class="card-body">
                            <h5 class="card-title">D3 Farmasi</h5>
                            <p class="card-text">Mempersiapkan tenaga ahli di bidang farmasi yang kompeten dan beretika,
                                siap berkontribusi dalam pelayanan kesehatan masyarakat.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card program-card">
                        <div class="card-body">
                            <h5 class="card-title">D3 Analis Kesehatan</h5>
                            <p class="card-text">Membekali mahasiswa dengan kemampuan analisis laboratorium klinik serta
                                pemahaman ilmu kesehatan yang mendalam.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card program-card">
                        <div class="card-body">
                            <h5 class="card-title">D3 Manajemen Informatika</h5>
                            <p class="card-text">Mengembangkan kemampuan dalam pengelolaan sistem informasi,
                                pemrograman, dan teknologi berbasis web modern.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pendaftaran Singkat -->
    <section class="py-5 text-center">
        <div class="container">
            <h2 class="mb-3">Pendaftaran Mahasiswa Baru</h2>
            <p class="mb-3">Segera daftarkan diri Anda untuk bergabung bersama kami dan raih masa depan cerah.</p>
            <a href="pendaftaran.php" class="btn btn-outline-warning">Daftar Sekarang</a>
        </div>
    </section>

    <!-- Kontak Singkat -->
    <section class="py-5 bg-light text-center">
        <div class="container">
            <h2 class="mb-3">Hubungi Kami</h2>
            <p class="mb-3">Butuh bantuan atau informasi lebih lanjut? Silakan hubungi kami.</p>
            <a href="kontak.php" class="btn btn-outline-warning">Hubungi Kami</a>
        </div>
    </section>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>