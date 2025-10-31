<?php
include '../includes/koneksi.php';
require_once '../includes/auth.php';

$toast_message = "";

// --- Pagination + Search + Show Data ---
$show = isset($_GET['show']) ? (int) $_GET['show'] : 5;
$allowed_limits = [1, 5, 10, 15, 20, 25, 50, 100];
if (!in_array($show, $allowed_limits)) $show = 5;

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$start = ($page - 1) * $show;

$cari = isset($_GET['cari']) ? mysqli_real_escape_string($conn, $_GET['cari']) : '';

if (!empty($cari)) {
    $where = "WHERE nama_lengkap LIKE '%$cari%' OR username LIKE '%$cari%'";
} else {
    $where = "";
}

$query = "SELECT * FROM tb_user $where ORDER BY id_user DESC LIMIT $start, $show";
$countQuery = "SELECT COUNT(*) AS total FROM tb_user $where";

$result = mysqli_query($conn, $query);
$totalData = mysqli_fetch_assoc(mysqli_query($conn, $countQuery))['total'];
$totalPages = ceil($totalData / $show);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola User | Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" href="../img/logo_mkm.png" type="image/x-icon">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .content {
            margin-left: 260px;
            padding: 90px 20px 20px;
        }

        @media (max-width: 991px) {
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

        .table th {
            background-color: #0d6efd;
            color: #fff;
            text-align: center;
        }

        .table td {
            text-align: center;
            vertical-align: middle;
        }
    </style>
</head>

<body>
    <?php include 'sidebar_admin.php'; ?>
    <div class="content">
        <div class="container-fluid">
            <h3 class="fw-bold mb-4"><i class="bi bi-people-fill me-2"></i>Kelola User</h3>

            <div class="card">
                <div class="card-body">
                    <!-- Tombol dan pencarian -->
                    <div class="d-flex justify-content-between mb-3 flex-wrap gap-2">
                        <form class="d-flex" method="get">
                            <input type="hidden" name="show" value="<?= $show ?>">
                            <input type="text" name="cari" class="form-control" placeholder="Cari nama/NIK..."
                                value="<?= htmlspecialchars($cari) ?>">
                            <button class="btn btn-outline-secondary ms-2"><i class="bi bi-search"></i></button>
                        </form>
                    </div>

                    <!-- Dropdown Show -->
                    <div class="mb-3">
                        <form method="get" class="d-inline">
                            <?php if (!empty($cari)): ?>
                                <input type="hidden" name="cari" value="<?= htmlspecialchars($cari) ?>">
                            <?php endif; ?>
                            <label for="show" class="me-2 fw-semibold">Tampilkan</label>
                            <select name="show" id="show" class="form-select d-inline w-auto"
                                onchange="this.form.submit()">
                                <?php foreach ($allowed_limits as $limit): ?>
                                    <option value="<?= $limit ?>" <?= ($limit == $show) ? 'selected' : '' ?>>
                                        <?= $limit ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <span class="ms-2">data per halaman</span>
                        </form>
                    </div>

                    <!-- Tabel User -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Lengkap</th>
                                    <th>Username (NIK)</th>
                                    <th>Role</th>
                                    <th>Tanggal Daftar</th>
                                    <th>Status Akun</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (mysqli_num_rows($result) > 0) {
                                    $no = $start + 1;
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $badgeClass = ($row['status_akun'] == 'aktif') ? 'bg-success' : 'bg-secondary';
                                        echo "
                                        <tr>
                                            <td>{$no}</td>
                                            <td>" . htmlspecialchars($row['nama_lengkap']) . "</td>
                                            <td>" . htmlspecialchars($row['username']) . "</td>
                                            <td>" . ucfirst($row['role']) . "</td>
                                            <td>" . date('d-m-Y H:i', strtotime($row['tanggal_daftar'])) . "</td>
                                            <td><span class='badge {$badgeClass}'>" . ucfirst($row['status_akun']) . "</span></td>
                                            <td>
                                                <form action='../registrasi/update_status_user.php' method='POST' class='d-inline'>
                                                    <input type='hidden' name='id_user' value='{$row['id_user']}'>
                                                    <select name='status_akun' class='form-select form-select-sm d-inline w-auto'
                                                        onchange='this.form.submit()'>
                                                        <option value='aktif' " . (($row['status_akun'] == 'aktif') ? 'selected' : '') . ">Aktif</option>
                                                        <option value='nonaktif' " . (($row['status_akun'] == 'nonaktif') ? 'selected' : '') . ">Nonaktif</option>
                                                    </select>
                                                </form>
                                                <a href='hapus_user.php?id={$row['id_user']}' class='btn btn-sm btn-danger'
                                                    onclick='return confirm(\"Yakin ingin menghapus user ini?\")'><i class='bi bi-trash'></i></a>
                                            </td>
                                        </tr>";
                                        $no++;
                                    }
                                } else {
                                    echo "<tr><td colspan='7' class='text-center text-muted'>Belum ada user terdaftar.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Info Data + Pagination -->
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
                                        href="?page=<?= $page - 1 ?>&show=<?= $show ?>&cari=<?= urlencode($cari) ?>">Previous</a>
                                </li>

                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                                        <a class="page-link"
                                            href="?page=<?= $i ?>&show=<?= $show ?>&cari=<?= urlencode($cari) ?>"><?= $i ?></a>
                                    </li>
                                <?php endfor; ?>

                                <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                                    <a class="page-link"
                                        href="?page=<?= $page + 1 ?>&show=<?= $show ?>&cari=<?= urlencode($cari) ?>">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
