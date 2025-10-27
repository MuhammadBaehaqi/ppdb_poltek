<?php include 'navbar.php'; ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran | Politeknik Mitra Karya Mandiri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero-section {
            position: relative;
            height: 75vh;
            overflow: hidden;
            color: white;
            text-align: center;
        }
        .hero-section img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(60%);
        }
        .hero-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(0, 0, 0, 0.55);
            border-radius: 10px;
            padding: 20px 30px;
            width: 70%;
        }
        .hero-content h1 {
            font-weight: 600;
        }
        .hero-content a.btn {
            border: 2px solid #ff9800;
            color: white;
            background-color: transparent;
            transition: 0.3s;
        }
        .hero-content a.btn:hover {
            background-color: #ff9800;
            color: white;
        }

        /* Langkah Pendaftaran */
        .step-box {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
            padding: 25px 20px;
            transition: transform 0.3s ease;
        }
        .step-box:hover {
            transform: translateY(-5px);
        }
        .step-icon {
            background-color: #ff9800;
            color: white;
            font-size: 24px;
            width: 60px;
            height: 60px;
            line-height: 60px;
            border-radius: 50%;
            margin: 0 auto 15px;
        }
        .step-box h5 {
            font-weight: 600;
        }

        /* Form */
        table {
            width: 100%;
        }
        table td {
            padding: 10px;
            vertical-align: middle;
        }
        table input, table select, table textarea {
            width: 100%;
        }
    </style>
</head>
<body>

<!-- Hero Section -->
<section class="hero-section">
    <img src="img/foto_login.jpg" alt="Pendaftaran Mahasiswa Baru">
    <div class="hero-content">
        <h1>Pendaftaran Mahasiswa Baru</h1>
        <p>Bergabunglah bersama kami dan wujudkan masa depan gemilang di Politeknik Mitra Karya Mandiri</p>
        <a href="#langkahPendaftaran" class="btn btn-outline-warning mt-2">Mulai Daftar</a>
    </div>
</section>

<!-- Langkah-langkah Pendaftaran -->
<section id="langkahPendaftaran" class="py-5">
    <div class="container text-center">
        <h2 class="mb-4">Langkah-langkah Pendaftaran</h2>
        <div class="row g-4 justify-content-center">
            <div class="col-md-3">
                <div class="step-box">
                    <div class="step-icon">1</div>
                    <h5>Isi Formulir Online</h5>
                    <p class="text-muted">Lengkapi data diri Anda pada form pendaftaran secara online dengan benar.</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="step-box">
                    <div class="step-icon">2</div>
                    <h5>Verifikasi Data</h5>
                    <p class="text-muted">Pihak kampus akan melakukan verifikasi data dan dokumen yang telah Anda kirimkan.</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="step-box">
                    <div class="step-icon">3</div>
                    <h5>Konfirmasi & Pembayaran</h5>
                    <p class="text-muted">Setelah verifikasi berhasil, Anda akan menerima konfirmasi dan instruksi pembayaran.</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="step-box">
                    <div class="step-icon">4</div>
                    <h5>Menjadi Mahasiswa</h5>
                    <p class="text-muted">Selamat! Anda resmi menjadi mahasiswa Politeknik Mitra Karya Mandiri.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Form Pendaftaran -->
<section id="formPendaftaran" class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-4">Formulir Pendaftaran</h2>
        <p class="text-center text-muted mb-5">Silakan isi data dengan lengkap untuk melakukan pendaftaran.</p>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <form>
                    <table class="table table-bordered bg-white shadow-sm">
                        <tr>
                            <td width="30%"><strong>Nama Lengkap</strong></td>
                            <td><input type="text" class="form-control" placeholder="Masukkan nama lengkap Anda"></td>
                        </tr>
                        <tr>
                            <td><strong>Email</strong></td>
                            <td><input type="email" class="form-control" placeholder="contoh@email.com"></td>
                        </tr>
                        <tr>
                            <td><strong>Nomor Telepon</strong></td>
                            <td><input type="text" class="form-control" placeholder="08xxxxxxxxxx"></td>
                        </tr>
                        <tr>
                            <td><strong>Program Studi</strong></td>
                            <td>
                                <select class="form-select">
                                    <option selected disabled>Pilih Program Studi</option>
                                    <option>D3 Farmasi</option>
                                    <option>D3 Analis Kesehatan</option>
                                    <option>D3 Manajemen Informatika</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Alamat Lengkap</strong></td>
                            <td><textarea class="form-control" rows="3" placeholder="Masukkan alamat lengkap Anda"></textarea></td>
                        </tr>
                    </table>
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-warning px-5 py-2 fw-semibold">Kirim Pendaftaran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
