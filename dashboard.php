<?php include 'sidebar.php'; ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            overflow-x: hidden;
            background-color: #f8f9fa;
        }

        .sidebar {
            width: 250px;
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #212529;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar {
            margin-left: 250px;
            background-color: #ffffff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <!-- Navbar Atas -->
    <nav class="navbar navbar-expand-lg navbar-light px-4 fixed-top">
        <div class="container-fluid">
            <h5 class="fw-bold mb-0">Dashboard Admin</h5>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle"
                    id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="img/logo.png" alt="" width="32" height="32" class="rounded-circle me-2">
                    <strong>Admin</strong>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="dropdownUser">
                    <li><a class="dropdown-item" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Konten Utama -->
    <div class="content mt-5 pt-4">
        <div class="container-fluid">
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="card text-center text-white bg-primary">
                        <div class="card-body">
                            <i class="bi bi-people-fill display-5"></i>
                            <h5 class="card-title mt-2">Total Mahasiswa</h5>
                            <p class="card-text fs-4">120</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card text-center text-white bg-success">
                        <div class="card-body">
                            <i class="bi bi-person-plus-fill display-5"></i>
                            <h5 class="card-title mt-2">Pendaftaran Baru</h5>
                            <p class="card-text fs-4">25</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card text-center text-white bg-warning">
                        <div class="card-body">
                            <i class="bi bi-envelope-fill display-5"></i>
                            <h5 class="card-title mt-2">Pesan Masuk</h5>
                            <p class="card-text fs-4">8</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card text-center text-white bg-danger">
                        <div class="card-body">
                            <i class="bi bi-clock-history display-5"></i>
                            <h5 class="card-title mt-2">Riwayat</h5>
                            <p class="card-text fs-4">42</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-white fw-bold">
                    Aktivitas Terbaru
                </div>
                <div class="card-body">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Kegiatan</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Muhammad Rizki</td>
                                <td>Login ke sistem</td>
                                <td>28 Oktober 2025</td>
                                <td><span class="badge bg-success">Sukses</span></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Ahmad Zaky</td>
                                <td>Menambahkan data pendaftaran</td>
                                <td>28 Oktober 2025</td>
                                <td><span class="badge bg-info text-dark">Berhasil</span></td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Siti Nurhaliza</td>
                                <td>Mengirim pesan</td>
                                <td>27 Oktober 2025</td>
                                <td><span class="badge bg-warning text-dark">Pending</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>