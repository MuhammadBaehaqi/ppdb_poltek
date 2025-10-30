<?php 
include 'sidebar_admin.php'; 
include 'koneksi.php';

// --- Pagination + Search + Show x data ---
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Buat kondisi WHERE jika search ada
$where = '';
if ($search != '') {
    $where = "WHERE nama_lengkap LIKE '%$search%' OR username LIKE '%$search%'";
}

// Hitung total data
$totalData = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM tb_user $where"))['total'];
$totalPages = ceil($totalData / $limit);

// Ambil data sesuai limit dan offset
$sql = "SELECT * FROM tb_user $where ORDER BY id_user DESC LIMIT $start, $limit";
$query = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola User | Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .content {
            margin-left: 260px;
            padding: 90px 20px 20px 20px;
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

<!-- Konten Utama -->
<div class="content">
    <div class="container-fluid">
        <h3 class="fw-bold mb-4"><i class="bi bi-people-fill me-2"></i>Kelola User</h3>

        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3 flex-wrap gap-2">
                    <!-- Show & Search -->
                    <div class="d-flex align-items-center gap-2">
                        <form id="form-limit" method="get" class="d-flex align-items-center">
                            <label class="me-2 mb-0">Tampilkan:</label>
                            <select name="limit" class="form-select form-select-sm" onchange="document.getElementById('form-limit').submit()">
                                <?php foreach([5,10,15,20,50] as $l): ?>
                                    <option value="<?= $l ?>" <?= $limit==$l?'selected':'' ?>><?= $l ?></option>
                                <?php endforeach; ?>
                            </select>
                            <input type="hidden" name="search" value="<?= htmlspecialchars($search) ?>">
                        </form>

                        <form method="get" class="d-flex">
                            <input type="text" name="search" class="form-control" placeholder="Cari nama/NIK..." value="<?= htmlspecialchars($search) ?>">
                            <input type="hidden" name="limit" value="<?= $limit ?>">
                            <button class="btn btn-outline-secondary ms-2"><i class="bi bi-search"></i></button>
                        </form>
                    </div>
                    </div>

                <!-- Table Responsive -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Lengkap</th>
                                <th>NIK (Username)</th>
                                <th>Role</th>
                                <th>Tanggal Daftar</th>
                                <th>Status Akun</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = $start + 1; // nomor urut sesuai page
                                if (mysqli_num_rows($query) > 0) {
                                    while ($row = mysqli_fetch_assoc($query)) {
                                        $badgeClass = ($row['status_akun'] == 'aktif') ? 'bg-success' : 'bg-secondary';
                                        echo "<tr>
                                            <td>{$no}</td>
                                            <td>".htmlspecialchars($row['nama_lengkap'])."</td>
                                            <td>".htmlspecialchars($row['username'])."</td>
                                            <td>".ucfirst($row['role'])."</td>
                                            <td>".date('d-m-Y H:i', strtotime($row['tanggal_daftar']))."</td>
                                            <td><span class='badge {$badgeClass}'>".ucfirst($row['status_akun'])."</span></td>
                                            <td>
                                                <form action='registrasi/update_status_user.php' method='POST' class='d-inline'>
                                                    <input type='hidden' name='id_user' value='{$row['id_user']}'>
                                                    <select name='status_akun' class='form-select form-select-sm d-inline w-auto' onchange='this.form.submit()'>
                                                        <option value='aktif' ".($row['status_akun']=='aktif'?'selected':'').">Aktif</option>
                                                        <option value='nonaktif' ".($row['status_akun']=='nonaktif'?'selected':'').">Nonaktif</option>
                                                    </select>
                                                </form>
                                                <a href='hapus_user.php?id={$row['id_user']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Yakin ingin menghapus user ini?\");'><i class='bi bi-trash'></i></a>
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

                <!-- Pagination (opsional) -->
                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
                    <div class="text-muted small mb-2 mb-md-0">
                        Menampilkan <?= $start+1 ?>–<?= min($start+$limit,$totalData) ?> dari <?= $totalData ?> data
                    </div>
                    <nav>
                        <ul class="pagination pagination-sm mb-0">
                            <li class="page-item <?= ($page<=1)?'disabled':'' ?>">
                                <a class="page-link" href="?page=<?= $page-1 ?>&search=<?= urlencode($search) ?>&limit=<?= $limit ?>">Previous</a>
                            </li>
                            <?php for($i=1;$i<=$totalPages;$i++): ?>
                                <li class="page-item <?= ($page==$i)?'active':'' ?>">
                                    <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>&limit=<?= $limit ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                            <li class="page-item <?= ($page>=$totalPages)?'disabled':'' ?>">
                                <a class="page-link" href="?page=<?= $page+1 ?>&search=<?= urlencode($search) ?>&limit=<?= $limit ?>">Next</a>
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
