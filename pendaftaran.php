<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran | Politeknik Mitra Karya Mandiri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="img/logo_mkm.png" type="image/x-icon">
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
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
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
        .form-wrapper {
            background-color: #fff;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
        }

        table td {
            padding: 10px;
            vertical-align: middle;
        }

        .note {
            font-size: 14px;
            color: #6c757d;
        }

        .form-header {
            background-color: #ff9800;
            color: white;
            padding: 15px;
            border-radius: 10px 10px 0 0;
            font-weight: 600;
            text-align: center;
        }
    </style>
</head>
<?php include 'includes/navbar.php'; ?>

<body>

    <!-- Hero Section -->
    <section class="hero-section">
        <img src="img/slide3.jpg" alt="Pendaftaran Mahasiswa Baru">
        <div class="hero-content">
            <h1>Pendaftaran Mahasiswa Baru</h1>
            <p>Bergabunglah bersama kami dan wujudkan masa depan gemilang di Politeknik Mitra Karya Mandiri</p>
            <a href="#formPendaftaran" class="btn btn-outline-warning mt-2">Mulai Daftar</a>
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
                        <p class="text-muted">Lengkapi data diri Anda dengan benar pada form pendaftaran online.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="step-box">
                        <div class="step-icon">2</div>
                        <h5>Verifikasi Data</h5>
                        <p class="text-muted">Pihak kampus akan melakukan verifikasi data dan dokumen yang telah Anda
                            kirimkan.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="step-box">
                        <div class="step-icon">3</div>
                        <h5>Pembayaran</h5>
                        <p class="text-muted">Lakukan pembayaran biaya pendaftaran sesuai instruksi yang tertera.</p>
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
            <div class="form-header mb-4">FORMULIR PMB POLITEKNIK MKM</div>

            <div class="alert alert-info shadow-sm">
                Form Pendaftaran Mahasiswa Baru Politeknik MKM Brebes, diisi sesuai data yang sebenarnya untuk
                mempermudah proses PMB.
                <br>Jika ada kendala pengisian formulir atau info PMB dapat menghubungi:
                <ul class="mb-0">
                    <li>📞 <strong>Waoman:</strong> 0838 6160 6703</li>
                    <li>📞 <strong>Siska:</strong> 0895 3484 75546</li>
                    <li>📞 <strong>Umi:</strong> 0838 3850 8940</li>
                </ul>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-9">
                    <div class="form-wrapper">
                        <form action="registrasi/proses_pendaftaran.php" method="POST" enctype="multipart/form-data">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Nama Lengkap</strong></td>
                                    <td><input type="text" class="form-control" name="nama_lengkap"
                                            placeholder="Masukkan nama lengkap Anda" required></td>
                                </tr>
                                <tr>
                                    <td><strong>Email</strong></td>
                                    <td><input type="email" class="form-control" name="email"
                                            placeholder="Masukkan alamat email aktif Anda" required></td>
                                </tr>
                                <!-- 🟩 Field Baru: Nomor WhatsApp -->
                               <tr>
                                    <td><strong>Nomor WhatsApp</strong></td>
                                    <td>
                                        <input type="text" class="form-control" name="nomor_wa"
                                            placeholder="Contoh: 081234567890" required
                                            pattern="^(\+?62\d{8,15}|0\d{8,15})$"
                                            title="Masukkan nomor WhatsApp yang benar, contoh: 081234567890 atau +6281234567890">
                                        <small class="note">Gunakan nomor WhatsApp aktif yang bisa dihubungi oleh
                                            panitia PMB.</small>
                                    </td>
                                </tr>
                                <!-- 🟩 Selesai -->
                                <tr>
                                    <td><strong>Jenis Kelamin</strong></td>
                                    <td>
                                        <select class="form-select" name="jenis_kelamin" required>
                                            <option selected disabled>Pilih Jenis Kelamin</option>
                                            <option value="Laki-laki">Laki-laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Alamat</strong></td>
                                    <td><textarea class="form-control" name="alamat" rows="3"
                                            placeholder="Masukkan alamat lengkap Anda" required></textarea></td>
                                </tr>
                                <tr>
                                    <td><strong>NIK</strong></td>
                                    <td>
                                        <input type="text" class="form-control" name="nik"
                                            placeholder="Masukkan NIK Anda" required
                                            pattern="[0-9]{16}"
                                            title="NIK harus terdiri dari 16 digit angka">
                                        <small class="note">Jika belum ber-KTP, gunakan NIK yang tertera pada Kartu Keluarga.</small>
                                    </td>
                                </tr>

                                <tr>
                                    <td><strong>NISN</strong></td>
                                    <td>
                                        <input type="text" class="form-control" name="nisn"
                                            placeholder="Masukkan NISN Anda" required
                                            pattern="[0-9]{10}"
                                            title="NISN harus terdiri dari 10 digit angka">
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Asal SLTA</strong></td>
                                    <td><input type="text" class="form-control" name="asal_slta"
                                            placeholder="SMA/MA/SMK/Lainnya" required></td>
                                </tr>
                                <tr>
                                    <td><strong>Program Studi Pilihan</strong></td>
                                    <td>
                                        <select class="form-select" name="program_studi" required>
                                            <option selected disabled>Pilih Program Studi</option>
                                            <option value="farmasi">D3 Farmasi</option>
                                            <option value="Analis Kesehatan">D3 Analis Kesehatan</option>
                                            <option value="Manajemen Informatika">D3 Manajemen Informatika</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Rencana Perkuliahan</strong></td>
                                    <td>
                                        <select class="form-select" name="rencana_kelas" required>
                                            <option selected disabled>Pilih Jenis Kelas</option>
                                            <option value="Kelas Reguler">Kelas Reguler</option>
                                            <option value="Kelas Karyawan">Kelas Karyawan</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Unggah Bukti Pembayaran</strong></td>
                                    <td>
                                        <input type="file" class="form-control" name="bukti_pembayaran"
                                            accept=".jpg,.jpeg,.pdf" required>
                                        <small class="note">
                                            Format: JPEG atau PDF | Maksimal 1 MB <br>
                                            <strong>No Rekening Kampus (BRI):</strong> 390101030201530 <br>
                                            <strong>Atas Nama:</strong> Politeknik Mitra Karya Mandiri
                                        </small>
                                    </td>
                                </tr>
                            </table>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-warning px-5 py-2 fw-semibold">
                                    Kirim Pendaftaran
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>