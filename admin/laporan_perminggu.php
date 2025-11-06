<?php
include '../includes/koneksi.php';
require_once '../includes/auth.php';

// --- Ambil parameter tanggal ---
$mulai = $_GET['mulai'] ?? date('Y-m-01');
$selesai = $_GET['selesai'] ?? date('Y-m-d');

// --- Ambil parameter show dan search ---
$show = isset($_GET['show']) ? (int) $_GET['show'] : 10;
$allowed_limits = [5, 10, 15, 20, 25, 50, 100];
if (!in_array($show, $allowed_limits)) $show = 10;

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
if ($page < 1) $page = 1;
$start = ($page - 1) * $show;

$cari = isset($_GET['cari']) ? mysqli_real_escape_string($conn, $_GET['cari']) : '';

// --- Query utama ---
$where = "WHERE DATE(tanggal_daftar) BETWEEN '$mulai' AND '$selesai'";
if (!empty($cari)) {
    $where .= " AND (nama_lengkap LIKE '%$cari%' OR nik LIKE '%$cari%')";
}

$query = "SELECT * FROM tb_pendaftaran $where ORDER BY tanggal_daftar DESC LIMIT $start, $show";
$result = mysqli_query($conn, $query);

$countQuery = "SELECT COUNT(*) AS total FROM tb_pendaftaran $where";
$totalData = mysqli_fetch_assoc(mysqli_query($conn, $countQuery))['total'];
$totalPages = ceil($totalData / $show);

// --- Hitung jumlah pendaftar total untuk grafik ---
$totalAll = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tb_pendaftaran $where"));
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
        body { background-color: #f8f9fa; }
        .content { margin-left: 260px; padding: 90px 20px 20px; }
        @media (max-width: 768px) { .content { margin-left: 0; padding-top: 100px; } }
        .card { border: none; box-shadow: 0px 2px 10px rgba(0,0,0,0.1); border-radius: 12px; }
        table th { background-color: #0d6efd; color: #fff; text-align: center; }
        table td { vertical-align: middle; text-align: center; }
    </style>
</head>

<body>
    <?php include 'sidebar_admin.php'; ?>

    <div class="content">
        <div class="container-fluid">
            <h3 class="fw-bold mb-4"><i class="bi bi-calendar-week me-2"></i>Laporan Pendaftaran Per Minggu</h3>

            <!-- Filter Tanggal -->
            <form method="GET" class="row g-3 mb-4">
                <div class="col-md-4">
                    <label for="mulai" class="form-label">Tanggal Mulai</label>
                    <input type="date" id="mulai" name="mulai" class="form-control"
                        value="<?= $mulai ?>" required>
                </div>
                <div class="col-md-4">
                    <label for="selesai" class="form-label">Tanggal Selesai</label>
                    <input type="date" id="selesai" name="selesai" class="form-control"
                        value="<?= $selesai ?>" required>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search me-2"></i>Tampilkan
                    </button>
                </div>
            </form>

            <!-- Card Grafik -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Jumlah Pendaftar: <?= $totalAll ?> orang</h5>
                    <canvas id="chartMinggu" height="100"></canvas>
                </div>
            </div>

            <!-- Tabel Data -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3 flex-wrap gap-2">
                        <!-- Search -->
                        <form class="d-flex" method="get">
                            <input type="hidden" name="mulai" value="<?= $mulai ?>">
                            <input type="hidden" name="selesai" value="<?= $selesai ?>">
                            <input type="hidden" name="show" value="<?= $show ?>">
                            <input type="text" name="cari" class="form-control" placeholder="Cari nama atau NIK..."
                                value="<?= htmlspecialchars($cari) ?>">
                            <button class="btn btn-outline-secondary ms-2"><i class="bi bi-search"></i></button>
                        </form>

                        <!-- Dropdown Show -->
                        <form method="get" class="d-inline">
                            <input type="hidden" name="mulai" value="<?= $mulai ?>">
                            <input type="hidden" name="selesai" value="<?= $selesai ?>">
                            <?php if (!empty($cari)): ?>
                                <input type="hidden" name="cari" value="<?= htmlspecialchars($cari) ?>">
                            <?php endif; ?>
                            <label for="show" class="me-2 fw-semibold">Tampilkan</label>
                            <select name="show" id="show" class="form-select d-inline w-auto" onchange="this.form.submit()">
                                <?php foreach ($allowed_limits as $limit): ?>
                                    <option value="<?= $limit ?>" <?= ($limit == $show) ? 'selected' : '' ?>><?= $limit ?></option>
                                <?php endforeach; ?>
                            </select>
                            <span class="ms-2">data per halaman</span>
                        </form>
                    </div>

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
                                if (mysqli_num_rows($result) > 0) {
                                    $no = $start + 1;
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $status = $row['status_pendaftaran'];
                                        $badge = $status == 'Diterima' ? 'success' : ($status == 'Tidak Diterima' ? 'danger' : 'warning text-dark');
                                        echo "<tr>
                                                <td>{$no}</td>
                                                <td>{$row['nama_lengkap']}</td>
                                                <td>{$row['nik']}</td>
                                                <td>" . date('d-m-Y', strtotime($row['tanggal_daftar'])) . "</td>
                                                <td><span class='badge bg-{$badge}'>{$status}</span></td>
                                              </tr>";
                                        $no++;
                                    }
                                } else {
                                    echo "<tr><td colspan='5' class='text-center text-muted'>Tidak ada data untuk rentang ini.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Info data + Pagination -->
                    <?php
                    $start_data = ($page - 1) * $show + 1;
                    $end_data = min($start_data + $show - 1, $totalData);
                    ?>
                    <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
                        <div class="text-muted small mb-2 mb-md-0">
                            Menampilkan <strong><?= $start_data ?></strong>–<strong><?= $end_data ?></strong> dari
                            <strong><?= $totalData ?></strong> data
                        </div>

                        <nav>
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                                    <a class="page-link"
                                        href="?page=<?= $page - 1 ?>&show=<?= $show ?>&mulai=<?= $mulai ?>&selesai=<?= $selesai ?>&cari=<?= urlencode($cari) ?>">Previous</a>
                                </li>

                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                                        <a class="page-link"
                                            href="?page=<?= $i ?>&show=<?= $show ?>&mulai=<?= $mulai ?>&selesai=<?= $selesai ?>&cari=<?= urlencode($cari) ?>"><?= $i ?></a>
                                    </li>
                                <?php endfor; ?>

                                <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                                    <a class="page-link"
                                        href="?page=<?= $page + 1 ?>&show=<?= $show ?>&mulai=<?= $mulai ?>&selesai=<?= $selesai ?>&cari=<?= urlencode($cari) ?>">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>

                    <!-- Tombol Cetak -->
                    <div class="mt-3">
                        <a href="cetak/cetak_laporan.php?mingguan=1&mulai=<?= $mulai ?>&selesai=<?= $selesai ?>" target="_blank"
                            class="btn btn-danger">
                            <i class="bi bi-file-earmark-pdf me-2"></i>Cetak PDF
                        </a>
                        <a href="cetak/cetak_laporan_excel.php?mingguan=1&mulai=<?= $mulai ?>&selesai=<?= $selesai ?>" target="_blank"
                            class="btn btn-success">
                            <i class="bi bi-file-earmark-excel me-2"></i>Cetak Excel
                        </a>
                    </div>
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
                    data: [<?= $totalAll ?>],
                    backgroundColor: 'rgba(13,110,253,0.6)',
                    borderColor: 'rgba(13,110,253,1)',
                    borderWidth: 1
                }]
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
