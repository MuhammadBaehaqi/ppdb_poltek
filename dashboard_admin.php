<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php?pesan=belum_login");
    exit();
}
include 'sidebar_admin.php';
?>

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

        /* Konten utama */
        .content {
            margin-left: 250px;
            padding: 90px 20px 20px;
            transition: all 0.3s;
        }

        /* Saat layar kecil, konten full width */
        @media (max-width: 991.98px) {
            .content {
                margin-left: 0;
            }
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div class="content">
        <div class="container-fluid">
            <!-- Kartu Statistik -->
            <div class="row g-4 mb-4">
                <div class="col-md-3 col-12">
                    <div class="card text-center text-white bg-primary">
                        <div class="card-body">
                            <i class="bi bi-people-fill display-5"></i>
                            <h5 class="card-title mt-2">Total Mahasiswa</h5>
                            <p class="card-text fs-4">120</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-12">
                    <div class="card text-center text-white bg-success">
                        <div class="card-body">
                            <i class="bi bi-person-plus-fill display-5"></i>
                            <h5 class="card-title mt-2">Pendaftaran Baru</h5>
                            <p class="card-text fs-4">25</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-12">
                    <div class="card text-center text-white bg-warning">
                        <div class="card-body">
                            <i class="bi bi-envelope-fill display-5"></i>
                            <h5 class="card-title mt-2">Pesan Masuk</h5>
                            <p class="card-text fs-4">8</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-12">
                    <div class="card text-center text-white bg-danger">
                        <div class="card-body">
                            <i class="bi bi-clock-history display-5"></i>
                            <h5 class="card-title mt-2">Riwayat</h5>
                            <p class="card-text fs-4">42</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Aktivitas Terbaru -->
            <div class="card">
                <div class="card-header bg-white fw-bold">
                    <i class="bi bi-activity me-2 text-primary"></i> Aktivitas Terbaru
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Waktu</th>
                                    <th>Nama Pengguna</th>
                                    <th>Aktivitas</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>29 Okt 2025, 08:42</td>
                                    <td><i class="bi bi-person-circle me-1"></i> Admin Utama</td>
                                    <td>Menambahkan data pendaftaran baru.</td>
                                    <td><span class="badge bg-success">Selesai</span></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>29 Okt 2025, 07:55</td>
                                    <td><i class="bi bi-person-circle me-1"></i> Haki</td>
                                    <td>Mengubah status pendaftar menjadi <strong>Lolos</strong>.</td>
                                    <td><span class="badge bg-info text-dark">Diperbarui</span></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>28 Okt 2025, 22:15</td>
                                    <td><i class="bi bi-person-circle me-1"></i> Admin 2</td>
                                    <td>Menghapus pesan kontak dari <strong>Dewi Lestari</strong>.</td>
                                    <td><span class="badge bg-danger">Dihapus</span></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>28 Okt 2025, 16:45</td>
                                    <td><i class="bi bi-person-circle me-1"></i> Admin Utama</td>
                                    <td>Menambahkan admin baru <strong>Rizky</strong>.</td>
                                    <td><span class="badge bg-primary">Ditambahkan</span></td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>28 Okt 2025, 09:20</td>
                                    <td><i class="bi bi-person-circle me-1"></i> Haki</td>
                                    <td>Login ke sistem admin.</td>
                                    <td><span class="badge bg-secondary">Aktif</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>