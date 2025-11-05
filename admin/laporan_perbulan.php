<?php
include '../includes/koneksi.php';
require_once '../includes/auth.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Per Bulan | Admin Panel</title>
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
            <h3 class="fw-bold mb-4"><i class="bi bi-calendar3 me-2"></i>Laporan Pendaftaran Per Bulan</h3>

            <form method="GET" class="row g-3 mb-4">
                <div class="col-md-4">
                    <label for="bulan" class="form-label">Pilih Bulan</label>
                    <select name="bulan" id="bulan" class="form-select">
                        <?php
                        $bulanDipilih = $_GET['bulan'] ?? date('m');
                        for ($i = 1; $i <= 12; $i++) {
                            $selected = ($i == (int) $bulanDipilih) ? 'selected' : '';
                            echo "<option value='$i' $selected>" . date('F', mktime(0, 0, 0, $i, 10)) . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="tahun" class="form-label">Pilih Tahun</label>
                    <select name="tahun" id="tahun" class="form-select">
                        <?php
                        $tahunDipilih = $_GET['tahun'] ?? date('Y');
                        $tahunSekarang = date('Y');
                        for ($i = 2020; $i <= $tahunSekarang; $i++) {
                            $selected = ($i == (int) $tahunDipilih) ? 'selected' : '';
                            echo "<option value='$i' $selected>$i</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search me-2"></i>Tampilkan
                    </button>
                </div>
            </form>

            <?php
            $bulan = $_GET['bulan'] ?? date('m');
            $tahun = $_GET['tahun'] ?? date('Y');

            $query = "SELECT * FROM tb_pendaftaran WHERE MONTH(tanggal_daftar) = '$bulan' AND YEAR(tanggal_daftar) = '$tahun'";
            $result = mysqli_query($conn, $query);
            $jumlah = mysqli_num_rows($result);
            ?>

            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Jumlah Pendaftar: <?= $jumlah ?> orang</h5>
                    <canvas id="chartBulan" height="100"></canvas>
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
                                    echo "<tr><td colspan='5' class='text-center text-muted'>Tidak ada data untuk bulan ini.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <a href="cetak/cetak_laporan.php?bulan=<?= $bulan ?>&tahun=<?= $tahun ?>" target="_blank"
                        class="btn btn-danger mt-3">
                        <i class="bi bi-file-earmark-pdf me-2"></i>Cetak PDF
                    </a>
                    <a href="cetak/cetak_laporan_excel.php?bulan=<?= $bulan ?>&tahun=<?= $tahun ?>" target="_blank"
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
        const ctx = document.getElementById('chartBulan').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['<?= date("F", mktime(0, 0, 0, $bulan, 10)) ?> <?= $tahun ?>'],
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