<?php
session_start();
$_SESSION['kontak_diklik'] = true;

require_once '../includes/auth.php';
include '../includes/koneksi.php';

// 🔹 Tandai semua pesan sudah dibaca
mysqli_query($conn, "UPDATE kontak SET status_baca = 'sudah baca' WHERE status_baca = 'belum baca'");

// 🔹 Pagination + Search + Show data
$show = isset($_GET['show']) ? (int) $_GET['show'] : 5;
$allowed_limits = [5, 10, 15, 20, 25, 50, 100];
if (!in_array($show, $allowed_limits)) $show = 5;

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
if ($page < 1) $page = 1;
$start = ($page - 1) * $show;

$cari = isset($_GET['cari']) ? mysqli_real_escape_string($conn, $_GET['cari']) : '';
if (!empty($cari)) {
    $where = "WHERE nama LIKE '%$cari%' OR email LIKE '%$cari%' OR nomor_wa LIKE '%$cari%'";
} else {
    $where = "";
}

// 🔹 Hitung total data
$countQuery = "SELECT COUNT(*) AS total FROM kontak $where";
$totalData = mysqli_fetch_assoc(mysqli_query($conn, $countQuery))['total'];
$totalPages = ceil($totalData / $show);

// 🔹 Ambil data kontak
$query = mysqli_query($conn, "SELECT * FROM kontak $where ORDER BY id_pesan DESC LIMIT $start, $show");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kontak | Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" href="../img/logo_mkm.png" type="image/x-icon">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .main-content {
            margin-left: 260px;
            padding: 90px 20px 20px;
        }

        @media (max-width: 992px) {
            .main-content {
                margin-left: 0;
                padding-top: 100px;
            }
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .table th {
            background-color: #0d6efd;
            color: white;
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

    <div class="main-content">
        <div class="container-fluid">
            <h3 class="fw-bold mb-4"><i class="bi bi-envelope-fill me-2"></i>Pesan Kontak</h3>

            <div class="card">
                <div class="card-body">
                    <!-- 🔹 Search dan Show -->
                    <div class="d-flex justify-content-between mb-3 flex-wrap gap-2">
                        <form class="d-flex" method="get">
                            <input type="hidden" name="show" value="<?= $show ?>">
                            <input type="text" name="cari" class="form-control" placeholder="Cari nama/email/WhatsApp..."
                                value="<?= htmlspecialchars($cari) ?>">
                            <button class="btn btn-outline-secondary ms-2"><i class="bi bi-search"></i></button>
                        </form>

                        <form method="get" class="d-flex align-items-center">
                            <?php if (!empty($cari)): ?>
                                <input type="hidden" name="cari" value="<?= htmlspecialchars($cari) ?>">
                            <?php endif; ?>
                            <label for="show" class="me-2 fw-semibold">Tampilkan</label>
                            <select name="show" id="show" class="form-select w-auto"
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

                    <!-- 🔹 Tabel Kontak -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Nomor WhatsApp</th>
                                    <th>Pesan</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (mysqli_num_rows($query) > 0) {
                                    $no = $start + 1;
                                    while ($row = mysqli_fetch_assoc($query)) {
                                        echo "
                                        <tr>
                                            <td>{$no}</td>
                                            <td>" . htmlspecialchars($row['nama']) . "</td>
                                            <td>" . htmlspecialchars($row['email']) . "</td>
                                            <td>" . htmlspecialchars($row['nomor_wa']) . "</td>
                                            <td class='text-start'>" . nl2br(htmlspecialchars($row['pesan'])) . "</td>
                                            <td>" . date('d-m-Y H:i', strtotime($row['tanggal'])) . "</td>
                                            <td>
                                                <a href='https://wa.me/{$row['nomor_wa']}' target='_blank' class='btn btn-sm btn-success me-1' title='Balas via WhatsApp'>
                                                    <i class='bi bi-whatsapp'></i>
                                                </a>
                                                <a href='mailto:{$row['email']}' class='btn btn-sm btn-primary me-1' title='Balas via Email'>
                                                    <i class='bi bi-envelope-fill'></i>
                                                </a>
                                                <a href='hapus_kontak.php?id={$row['id_pesan']}' class='btn btn-sm btn-danger' title='Hapus Pesan' onclick='return confirm(\"Yakin ingin menghapus pesan ini?\")'>
                                                    <i class='bi bi-trash-fill'></i>
                                                </a>
                                            </td>
                                        </tr>";
                                        $no++;
                                    }
                                } else {
                                    echo "<tr><td colspan='7' class='text-center text-muted'>Belum ada pesan masuk</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- 🔹 Info Data + Pagination -->
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
