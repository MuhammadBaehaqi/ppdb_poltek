<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php?pesan=belum_login");
    exit();
}

include '../includes/koneksi.php';

// Hitung total data
$totalMahasiswa = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM tb_pendaftaran"))['total'];
$pendaftaranBaru = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM tb_pendaftaran WHERE DATE(tanggal_daftar) = CURDATE()"))['total'];
$pesanMasuk = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM kontak"))['total'];
$totalUser = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM tb_user"))['total'];
$totalAdmin = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM admin"))['total'];

// Total keseluruhan
$totalRiwayat = $totalMahasiswa + $pesanMasuk + $totalUser + $totalAdmin;

// Pagination
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Hitung total aktivitas
$totalQuery = "
    SELECT COUNT(*) AS total FROM (
        (SELECT tanggal_daftar AS waktu FROM tb_pendaftaran)
        UNION ALL
        (SELECT tanggal AS waktu FROM kontak)
        UNION ALL
        (SELECT tanggal_daftar AS waktu FROM tb_user)
    ) AS all_activities
";
$totalRows = mysqli_fetch_assoc(mysqli_query($conn, $totalQuery))['total'];
$totalPages = ceil($totalRows / $limit);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" href="../img/logo_mkm.png" type="image/x-icon">
    <style>
        body { overflow-x: hidden; background-color: #f8f9fa; }
        .content { margin-left: 250px; padding: 90px 20px 20px; transition: all 0.3s; }
        @media (max-width: 991.98px) { .content { margin-left: 0; } }
        .card { border: none; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <?php include 'sidebar_admin.php'; ?>

    <div class="content">
        <div class="container-fluid">
            <!-- Statistik -->
            <div class="row g-4 mb-4">
                <!-- Total Pendaftaran -->
                <div class="col-md-3 col-12">
                    <div class="card text-center text-white bg-primary">
                        <div class="card-body">
                            <i class="bi bi-people-fill display-5"></i>
                            <h5 class="card-title mt-2">Total Pendaftaran</h5>
                            <p class="card-text fs-4"><?= $totalMahasiswa; ?></p>
                            <a href="data_pendaftaran.php" class="btn btn-light btn-sm mt-2">
                                <i class="bi bi-eye me-1"></i> Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Pendaftaran Hari Ini -->
                <div class="col-md-3 col-12">
                    <div class="card text-center text-white bg-success">
                        <div class="card-body">
                            <i class="bi bi-person-plus-fill display-5"></i>
                            <h5 class="card-title mt-2">Pendaftaran Hari Ini</h5>
                            <p class="card-text fs-4"><?= $pendaftaranBaru; ?></p>
                            <a href="data_pendaftaran.php" class="btn btn-light btn-sm mt-2">
                                <i class="bi bi-eye me-1"></i> Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Pesan Masuk -->
                <div class="col-md-3 col-12">
                    <div class="card text-center text-white bg-warning">
                        <div class="card-body">
                            <i class="bi bi-envelope-fill display-5"></i>
                            <h5 class="card-title mt-2">Pesan Masuk</h5>
                            <p class="card-text fs-4"><?= $pesanMasuk; ?></p>
                            <a href="data_kontak.php" class="btn btn-light btn-sm mt-2">
                                <i class="bi bi-eye me-1"></i> Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Total Admin -->
                <div class="col-md-3 col-12">
                    <div class="card text-center text-white bg-info">
                        <div class="card-body">
                            <i class="bi bi-person-gear display-5"></i>
                            <h5 class="card-title mt-2">Total Admin</h5>
                            <p class="card-text fs-4"><?= $totalAdmin; ?></p>
                            <a href="kelola_admin.php" class="btn btn-light btn-sm mt-2">
                                <i class="bi bi-eye me-1"></i> Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Total User -->
                <div class="col-md-3 col-12">
                    <div class="card text-center text-white bg-secondary">
                        <div class="card-body">
                            <i class="bi bi-person-badge display-5"></i>
                            <h5 class="card-title mt-2">Total User</h5>
                            <p class="card-text fs-4"><?= $totalUser; ?></p>
                            <a href="kelola_user.php" class="btn btn-light btn-sm mt-2">
                                <i class="bi bi-eye me-1"></i> Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Riwayat -->
                <div class="col-md-3 col-12">
                    <div class="card text-center text-white bg-danger">
                        <div class="card-body">
                            <i class="bi bi-clock-history display-5"></i>
                            <h5 class="card-title mt-2">Riwayat</h5>
                            <p class="card-text fs-4"><?= $totalRiwayat; ?></p>
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
                    <div class="d-flex justify-content-between mb-3">
                        <form method="GET" class="d-flex align-items-center">
                            <label class="me-2">Show</label>
                            <select name="limit" class="form-select w-auto" onchange="this.form.submit()">
                                <option value="5" <?= $limit==5?'selected':''; ?>>5</option>
                                <option value="10" <?= $limit==10?'selected':''; ?>>10</option>
                                <option value="20" <?= $limit==20?'selected':''; ?>>20</option>
                            </select>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Waktu</th>
                                    <th>Nama</th>
                                    <th>Kegiatan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $queryAktivitas = "
                                    (SELECT nama_lengkap AS nama, tanggal_daftar AS waktu, 'Pendaftaran Baru' AS kegiatan, status_pendaftaran AS status FROM tb_pendaftaran)
                                    UNION ALL
                                    (SELECT nama AS nama, tanggal AS waktu, 'Mengirim Pesan' AS kegiatan, 'Pesan Masuk' AS status FROM kontak)
                                    UNION ALL
                                    (SELECT nama_lengkap AS nama, tanggal_daftar AS waktu, 'Akun Terdaftar' AS kegiatan, status_akun AS status FROM tb_user)
                                    ORDER BY waktu DESC
                                    LIMIT $limit OFFSET $offset
                                ";
                                $result = mysqli_query($conn, $queryAktivitas);
                                $no = $offset + 1;

                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "
                                        <tr>
                                            <td>{$no}</td>
                                            <td>" . date('d M Y, H:i', strtotime($row['waktu'])) . "</td>
                                            <td><i class='bi bi-person-circle me-1'></i>" . htmlspecialchars($row['nama']) . "</td>
                                            <td>{$row['kegiatan']}</td>
                                            <td><span class='badge bg-info text-dark'>" . htmlspecialchars($row['status']) . "</span></td>
                                        </tr>";
                                        $no++;
                                    }
                                } else {
                                    echo "<tr><td colspan='5' class='text-center text-muted'>Tidak ada aktivitas terbaru</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <nav>
                        <ul class="pagination justify-content-end">
                            <li class="page-item <?= ($page <= 1) ? 'disabled' : ''; ?>">
                                <a class="page-link" href="?page=<?= $page-1; ?>&limit=<?= $limit; ?>">Previous</a>
                            </li>
                            <li class="page-item disabled">
                                <span class="page-link">Halaman <?= $page; ?> dari <?= $totalPages; ?></span>
                            </li>
                            <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : ''; ?>">
                                <a class="page-link" href="?page=<?= $page+1; ?>&limit=<?= $limit; ?>">Next</a>
                            </li>
                        </ul>
                    </nav>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
