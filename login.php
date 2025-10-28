<?php include 'navbar.php'; ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | Politeknik Mitra Karya Mandiri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: url('img/foto.jpeg') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        /* Overlay transparan tapi tidak menutupi navbar */
        .overlay {
            background-color: rgba(0, 0, 0, 0.55);
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1; /* di bawah navbar */
        }

        /* Navbar muncul di atas overlay */
        nav.navbar {
            position: relative;
            z-index: 10 !important;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(6px);
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
            z-index: 5;
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

        footer {
            z-index: 10;
            position: relative;
        }
    </style>
</head>
<body>

<div class="overlay"></div>

<!-- Kontainer Utama -->
<section class="d-flex justify-content-center align-items-center min-vh-100 position-relative z-3">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card login-card p-4 shadow-lg">
                    <div class="text-center mb-4 login-logo">
                        <img src="img/poltek.png" alt="Logo MKM">
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
                                <span class="input-group-text bg-warning text-white"><i class="bi bi-person-fill"></i></span>
                                <input type="text" id="username" name="username" class="form-control" placeholder="Masukkan username" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-warning text-white"><i class="bi bi-lock-fill"></i></span>
                                <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan password" required>
                            </div>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-warning fw-semibold py-2">Masuk</button>
                        </div>

                        <div class="text-center">
                            <a href="index.php" class="text-decoration-none text-secondary small"><i class="bi bi-arrow-left"></i> Kembali ke Beranda</a>
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