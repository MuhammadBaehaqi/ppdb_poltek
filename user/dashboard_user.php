<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php?pesan=belum_login");
    exit();
}
if ($_SESSION['role'] !== 'mahasiswa') {
    header("Location: ../login.php?pesan=akses_ditolak");
    exit();
}

include '../koneksi.php';

// Ambil data user
$nik = $_SESSION['username'];
$query = mysqli_query($conn, "SELECT * FROM tb_pendaftaran WHERE nik = '$nik' LIMIT 1");
$data = mysqli_fetch_assoc($query);
if (!$data) {
    echo "<script>alert('Data pendaftaran tidak ditemukan!');window.location='../login.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mahasiswa</title>
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

        /* Ukuran ikon Bootstrap sedang */
        .bi {
            font-size: 1.2rem;
            /* ukuran ikon sedang */
            vertical-align: middle;
        }

        /* Ukuran foto profil */
        .profile img,
        .card-body img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>

</head>

<body>

    <?php include 'sidebar_user.php'; ?>

    <div class="content">
        <div class="container-fluid">
            <!-- Profil Mahasiswa -->
            <div class="card mb-4">
                <div class="card-body d-flex align-items-center">
                    <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" alt="User Avatar" class="me-3">
                    <div>
                        <h5 class="mb-1">
                            <?= htmlspecialchars($data['nama_lengkap']); ?>
                        </h5>
                        <small class="text-muted">NIK:
                            <?= htmlspecialchars($data['nik']); ?> | Program Studi:
                            <?= htmlspecialchars($data['program_studi']); ?>
                        </small>
                    </div>
                </div>
            </div>

            <!-- Biodata Detail -->
            <div class="card">
                <div class="card-header bg-white fw-bold">
                    <i class="bi bi-person-lines-fill me-2 text-primary"></i> Detail Biodata
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <tbody>
                                <tr>
                                    <th>Nama Lengkap</th>
                                    <td>
                                        <?= htmlspecialchars($data['nama_lengkap']); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>NIK</th>
                                    <td>
                                        <?= htmlspecialchars($data['nik']); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>NISN</th>
                                    <td>
                                        <?= htmlspecialchars($data['nisn']); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Jenis Kelamin</th>
                                    <td>
                                        <?= htmlspecialchars($data['jenis_kelamin']); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Asal SLTA</th>
                                    <td>
                                        <?= htmlspecialchars($data['asal_slta']); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Program Studi</th>
                                    <td>
                                        <?= htmlspecialchars($data['program_studi']); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Rencana Kelas</th>
                                    <td>
                                        <?= htmlspecialchars($data['rencana_kelas']); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td>
                                        <?= htmlspecialchars($data['alamat']); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status Pendaftaran</th>
                                    <td><b>
                                            <?= htmlspecialchars($data['status_pendaftaran']); ?>
                                        </b></td>
                                </tr>
                                <tr>
                                    <th>Tanggal Daftar</th>
                                    <td>
                                        <?= date('d-m-Y', strtotime($data['tanggal_daftar'])); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Bukti Pembayaran</th>
                                    <td>
                                        <?php if (!empty($data['bukti_pembayaran'])): ?>
                                            <a href="../uploads/<?= htmlspecialchars($data['bukti_pembayaran']); ?>"
                                                target="_blank" class="btn btn-primary btn-sm">
                                                <i class="bi bi-eye"></i> Lihat Bukti
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">Belum ada bukti pembayaran.</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <footer class="text-center mt-4 mb-2 text-muted">
                &copy;
                <?= date('Y') ?> POLITEKNIK MITRA KARYA MANDIRI — Sistem Informasi Akademik
            </footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>