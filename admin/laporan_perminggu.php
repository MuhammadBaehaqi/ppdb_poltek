<?php
include '../includes/koneksi.php';
require_once '../includes/auth.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Per Minggu | Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" href="../img/logo_mkm.png" type="image/x-icon">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .content {
            margin-left: 260px;
            padding: 90px 20px 20px 20px;
        }

        @media (max-width: 768px) {
            .content {
                margin-left: 0;
                padding-top: 100px;
            }
        }

        .card {
            border: none;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
        }

        table th {
            background-color: #0d6efd;
            color: #fff;
            text-align: center;
        }

        table td {
            vertical-align: middle;
            text-align: center;
        }
    </style>
</head>

<body>
    <?php include 'sidebar_admin.php'; ?>

    <div class="content">
        <div class="container-fluid">
            <h3 class="fw-bold mb-4"><i class="bi bi-calendar-week me-2"></i>Laporan Pendaftaran Per Minggu</h3>

            <form method="GET" class="row g-3 mb-4">
                <div class="col-md-4">
                    <label for="mulai" class="form-label">Tanggal Mulai</label>
                    <input type="date" id="mulai" name="mulai" class="form-control"
                        value="<?= $_GET['mulai'] ?? date('Y-m-01') ?>" required>
                </div>
                <div class="col-md-4">
                    <label for="selesai" class="form-label">Tanggal Selesai</label>
                    <input type="date" id="selesai" name="selesai" class="form-control"
                        value="<?= $_GET['selesai'] ?? date('Y-m-d') ?>" required>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search me-2"></i>Tampilkan
                    </button>
                </div>
            </form>

            <?php
            $mulai = $_GET['mulai'] ?? date('Y-m-01');
            $selesai = $_GET['selesai'] ?? date('Y-m-d');

            $query = "SELECT * FROM tb_pendaftaran WHERE DATE(tanggal_daftar) BETWEEN '$mulai' AND '$selesai'";
            $result = mysqli_query($conn, $query);
            $jumlah = mysqli_num_rows($result);
            ?>

            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Jumlah Pendaftar: <?= $jumlah ?> orang</h5>
                    <canvas id="chartMinggu" height="100"></canvas>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Detail Data Pendaftar</h5>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Lengkap</th>
                                    <th>NIK</th>
                                    <th>Tanggal Daftar</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>
                                                <td>{$no}</td>
                                                <td>{$row['nama_lengkap']}</td>
                                                <td>{$row['nik']}</td>
                                                <td>" . date('d-m-Y', strtotime($row['tanggal_daftar'])) . "</td>
                                                <td><span class='badge bg-" .
                                            ($row['status_pendaftaran'] == 'Diterima' ? 'success' :
                                                ($row['status_pendaftaran'] == 'Tidak Diterima' ? 'danger' : 'warning text-dark')) .
                                            "'>{$row['status_pendaftaran']}</span></td>
                                              </tr>";
                                        $no++;
                                    }
                                } else {
                                    echo "<tr><td colspan='5' class='text-center text-muted'>Tidak ada data untuk rentang tanggal ini.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <a href="cetak/cetak_laporan.php?mingguan=1&mulai=<?= $mulai ?>&selesai=<?= $selesai ?>"
                        target="_blank" class="btn btn-danger mt-3">
                        <i class="bi bi-file-earmark-pdf me-2"></i>Cetak PDF
                    </a>
                    <a href="cetak/cetak_laporan_excel.php?mingguan=1&mulai=<?= $mulai ?>&selesai=<?= $selesai ?>" target="_blank"
                        class="btn btn-success mt-3">
                        <i class="bi bi-file-earmark-excel me-2"></i>Cetak Excel
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- ChartJS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctxM = document.getElementById('chartMinggu').getContext('2d');
        new Chart(ctxM, {
            type: 'bar',
            data: {
                labels: ['<?= date('d M', strtotime($mulai)) ?> - <?= date('d M Y', strtotime($selesai)) ?>'],
                datasets: [{
                    label: 'Jumlah Pendaftar',
                    data: [<?= $jumlah ?>],
                    backgroundColor: 'rgba(13, 110, 253, 0.6)',
                    borderColor: 'rgba(13, 110, 253, 1)',
                    borderWidth: 1
                }]
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>