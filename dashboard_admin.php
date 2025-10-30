<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php?pesan=belum_login");
    exit();
}
include 'sidebar_admin.php';
include 'koneksi.php';

// Hitung total data
$totalMahasiswa = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM tb_pendaftaran"))['total'];
$pendaftaranBaru = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM tb_pendaftaran WHERE DATE(tanggal_daftar) = CURDATE()"))['total'];
$pesanMasuk = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM kontak"))['total'];
$totalUser = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM tb_user"))['total'];
$totalAdmin = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM admin"))['total'];

// Total keseluruhan untuk "Riwayat"
$totalRiwayat = $totalMahasiswa + $pesanMasuk + $totalUser + $totalAdmin;
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
        .content {
            margin-left: 250px;
            padding: 90px 20px 20px;
            transition: all 0.3s;
        }
        @media (max-width: 991.98px) {
            .content { margin-left: 0; }
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
    </style>
</head>
<body>
    <div class="content">
        <div class="container-fluid">
            <!-- Statistik -->
            <div class="row g-4 mb-4">
                <div class="col-md-3 col-12">
    <div class="card text-center text-white bg-primary">
        <div class="card-body">
            <i class="bi bi-people-fill display-5"></i>
            <h5 class="card-title mt-2">Total Mahasiswa</h5>
            <p class="card-text fs-4"><?= $totalMahasiswa; ?></p>
            <a href="kelola_user.php" class="btn btn-light btn-sm mt-2">Lihat Detail</a>
        </div>
    </div>
</div>
<div class="col-md-3 col-12">
    <div class="card text-center text-white bg-success">
        <div class="card-body">
            <i class="bi bi-person-plus-fill display-5"></i>
            <h5 class="card-title mt-2">Pendaftaran Hari Ini</h5>
            <p class="card-text fs-4"><?= $pendaftaranBaru; ?></p>
            <a href="data_pendaftaran.php" class="btn btn-light btn-sm mt-2">Lihat Detail</a>
        </div>
    </div>
</div>

<div class="col-md-3 col-12">
    <div class="card text-center text-white bg-warning">
        <div class="card-body">
            <i class="bi bi-envelope-fill display-5"></i>
            <h5 class="card-title mt-2">Pesan Masuk</h5>
            <p class="card-text fs-4"><?= $pesanMasuk; ?></p>
            <a href="data_kontak.php" class="btn btn-light btn-sm mt-2">Lihat Detail</a>
        </div>
    </div>
</div>
<div class="col-md-3 col-12">
    <div class="card text-center text-white bg-dark">
        <div class="card-body">
            <i class="bi bi-person-gear-fill display-5"></i>
            <h5 class="card-title mt-2">Total Admin</h5>
            <p class="card-text fs-4"><?= $totalAdmin; ?></p>
            <a href="kelola_admin.php" class="btn btn-light btn-sm mt-2">Lihat Detail</a>
        </div>
    </div>
</div>
<div class="col-md-3 col-12">
    <div class="card text-center text-white bg-danger">
        <div class="card-body">
            <i class="bi bi-clock-history display-5"></i>
            <h5 class="card-title mt-2">Riwayat</h5>
            <p class="card-text fs-4"><?= $totalRiwayat; ?></p>
            <!-- Optional button jika mau diarahkan -->
            <!-- <a href="riwayat.php" class="btn btn-light btn-sm mt-2">Lihat Detail</a> -->
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
                                    <th>Nama</th>
                                    <th>Kegiatan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Ambil 5 aktivitas terakhir dari pendaftaran, kontak, dan user
                                $queryAktivitas = "
                                    (SELECT nama_lengkap AS nama, tanggal_daftar AS waktu, 'Pendaftaran Baru' AS kegiatan, status_pendaftaran AS status FROM tb_pendaftaran)
                                    UNION ALL
                                    (SELECT nama AS nama, tanggal AS waktu, 'Mengirim Pesan' AS kegiatan, 'Pesan Masuk' AS status FROM kontak)
                                    UNION ALL
                                    (SELECT nama_lengkap AS nama, tanggal_daftar AS waktu, 'Akun Terdaftar' AS kegiatan, status_akun AS status FROM tb_user)
                                    ORDER BY waktu DESC
                                    LIMIT 5";
                                $result = mysqli_query($conn, $queryAktivitas);
                                $no = 1;
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
                                ?>
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
