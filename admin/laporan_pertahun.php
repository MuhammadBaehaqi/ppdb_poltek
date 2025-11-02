<?php
include '../includes/koneksi.php';
require_once '../includes/auth.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Per Tahun | Admin Panel</title>
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
            <h3 class="fw-bold mb-4"><i class="bi bi-bar-chart-fill me-2"></i>Laporan Pendaftaran Per Tahun</h3>

            <form method="GET" class="row g-3 mb-4">
                <div class="col-md-6">
                    <label for="tahun" class="form-label">Pilih Tahun</label>
                    <select name="tahun" id="tahun" class="form-select">
                        <?php
                        $tahunSekarang = date('Y');
                        for ($i = 2020; $i <= $tahunSekarang; $i++) {
                            $selected = ($i == ($_GET['tahun'] ?? $tahunSekarang)) ? 'selected' : '';
                            echo "<option value='$i' $selected>$i</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-6 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search me-2"></i>Tampilkan
                    </button>
                </div>
            </form>

            <?php
            $tahun = $_GET['tahun'] ?? date('Y');
            $query = "SELECT MONTH(tanggal_daftar) AS bulan, COUNT(*) AS jumlah 
                      FROM tb_pendaftaran WHERE YEAR(tanggal_daftar) = '$tahun'
                      GROUP BY MONTH(tanggal_daftar)";
            $result = mysqli_query($conn, $query);

            $labels = [];
            $data = [];

            while ($row = mysqli_fetch_assoc($result)) {
                $labels[] = date('F', mktime(0, 0, 0, $row['bulan'], 10));
                $data[] = $row['jumlah'];
            }

            $total = array_sum($data);
            ?>

            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Total Pendaftar Tahun <?= $tahun ?>: <?= $total ?> orang</h5>
                    <canvas id="chartTahun" height="100"></canvas>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Detail Jumlah Pendaftar per Bulan</h5>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Bulan</th>
                                    <th>Jumlah Pendaftar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (count($labels) > 0) {
                                    $no = 1;
                                    for ($i = 0; $i < count($labels); $i++) {
                                        echo "<tr>
                                                <td>{$no}</td>
                                                <td>{$labels[$i]}</td>
                                                <td>{$data[$i]}</td>
                                              </tr>";
                                        $no++;
                                    }
                                } else {
                                    echo "<tr><td colspan='3' class='text-center text-muted'>Tidak ada data pendaftar di tahun ini.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <a href="cetak/cetak_laporan.php?tahun=<?= $tahun ?>" target="_blank" class="btn btn-danger mt-3">
                        <i class="bi bi-file-earmark-pdf me-2"></i>Cetak PDF
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- ChartJS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctxT = document.getElementById('chartTahun').getContext('2d');
        new Chart(ctxT, {
            type: 'line',
            data: {
                labels: <?= json_encode($labels) ?>,
                datasets: [{
                    label: 'Jumlah Pendaftar',
                    data: <?= json_encode($data) ?>,
                    backgroundColor: 'rgba(13, 110, 253, 0.3)',
                    borderColor: 'rgba(13, 110, 253, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>