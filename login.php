<?php
include 'includes/koneksi.php';

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | Politeknik Mitra Karya Mandiri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" href="img/logo_mkm.png" type="image/x-icon">
    <style>
        body {
            background: url('img/slide1.jpg') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            margin: 0;
            overflow: hidden;
            /* ini yang bikin gak bisa scroll */
        }

        /* Overlay transparan tapi tidak menutupi navbar */
        .overlay {
            background-color: rgba(0, 0, 0, 0.55);
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            /* di bawah navbar */
        }

        /* Navbar muncul di atas overlay */
        nav.navbar {
            position: relative;
            z-index: 10 !important;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.15);
            /* transparan putih */
            backdrop-filter: blur(15px);
            /* efek blur kaca */
            -webkit-backdrop-filter: blur(15px);
            /* untuk dukungan Safari */
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            /* garis lembut */
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.3);
            z-index: 5;
        }

        .login-card label,
        .login-card p,
        .login-card a,
        .login-card .form-label,
        .login-card .text-muted {
            color: #ffffff !important;
            /* semua teks putih */
        }

        .login-card h4 {
            color: #ff9800 !important;
            /* tulisan judul jadi oranye */
        }

        .login-card input::placeholder {
            color: rgba(255, 255, 255, 0.8) !important;
        }

        .login-card .input-group-text {
            background-color: rgba(255, 193, 7, 0.9);
            border: none;
        }

        .login-card .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: #fff;
        }

        .login-card .form-control:focus {
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
            border-color: #ffc107;
            box-shadow: 0 0 10px rgba(255, 193, 7, 0.4);
        }

        .login-logo img {
            width: 80px;
        }

        .btn-warning {
            background-color: #ff9800;
            border: none;
        }

        .btn-warning:hover {
            background-color: #e68900;
        }
    </style>
</head>
<? include 'navbar.php'; ?>

<body>

    <div class="overlay"></div>

    <!-- Kontainer Utama -->
    <section class="d-flex justify-content-center align-items-start position-relative z-3"
        style="height: 100vh; margin-top: 40px;">

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="card login-card p-4 shadow-lg">
                        <div class="text-center mb-4 login-logo">
                            <img src="img/logo_mkm.png" alt="Logo MKM">
                            <h4 class="fw-bold text-warning mt-3 mb-1">Politeknik Mitra Karya Mandiri</h4>
                            <p class="text-muted small">Halaman Login Administrator</p>
                        </div>

                        <?php
                        // Pesan error login gagal
                        if (isset($_GET['pesan']) && $_GET['pesan'] == 'gagal') {
                            echo '<div class="alert alert-danger text-center py-2">Login gagal! Username atau password salah.</div>';
                        }
                        ?>

                        <form action="cek_login.php" method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label fw-semibold">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-warning text-white"><i
                                            class="bi bi-person-fill"></i></span>
                                    <input type="text" id="username" name="username" class="form-control"
                                        placeholder="Masukkan username" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label fw-semibold">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-warning text-white"><i
                                            class="bi bi-lock-fill"></i></span>
                                    <input type="password" id="password" name="password" class="form-control"
                                        placeholder="Masukkan password" required>
                                </div>
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-warning fw-semibold py-2">Masuk</button>
                            </div>

                            <div class="text-center">
                                <a href="index.php" class="text-decoration-none text-secondary small"><i
                                        class="bi bi-arrow-left"></i> Kembali ke Beranda</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>