<?php
include '../includes/koneksi.php';
require_once '../includes/auth.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pendaftaran | Admin Panel</title>
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

        .table th {
            background-color: #0d6efd;
            color: #fff;
            text-align: center;
        }

        .table td {
            vertical-align: middle;
            text-align: center;
        }

        .pagination .page-link {
            color: #ff9800;
            border-color: #ff9800;
        }

        .pagination .page-item.active .page-link {
            background-color: #ff9800;
            border-color: #ff9800;
            color: white;
        }

        .pagination .page-link:hover {
            background-color: #ffe0b2;
        }
    </style>
</head>

<body>
    <?php include 'sidebar_admin.php'; ?>
    <div class="content">
        <div class="container-fluid">
            <h3 class="fw-bold mb-4"><i class="bi bi-person-lines-fill me-2"></i>Data Pendaftaran Mahasiswa</h3>

            <div class="card">
                <div class="card-body">

                    <!-- Tombol tambah, show dan search -->
                    <div class="d-flex flex-wrap justify-content-between mb-3 align-items-center">
                        <div class="d-flex align-items-center mb-2 mb-md-0">
                            <a href="pendaftaran_tambah.php" class="btn btn-primary me-3">
                                <i class="bi bi-plus-circle me-2"></i>Tambah Data
                            </a>
                            <form method="GET" class="d-flex align-items-center">
                                <label class="me-2 text-muted small">Tampilkan:</label>
                                <select name="limit" class="form-select form-select-sm me-2" onchange="this.form.submit()">
                                    <?php
                                    $limitOptions = [1, 5, 10, 15, 20, 25, 50, 100];
                                    $selectedLimit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
                                    foreach ($limitOptions as $opt) {
                                        $selected = ($opt == $selectedLimit) ? 'selected' : '';
                                        echo "<option value='$opt' $selected>$opt</option>";
                                    }
                                    ?>
                                </select>
                                <input type="hidden" name="search" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                            </form>
                        </div>

                        <form method="GET" class="d-flex">
                            <input type="hidden" name="limit" value="<?= $selectedLimit ?>">
                            <input type="text" name="search" class="form-control me-2"
                                placeholder="Cari nama, NIK, NISN, atau Email..."
                                value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                            <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Lengkap</th>
                                    <th>Email</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Alamat</th>
                                    <th>NIK</th>
                                    <th>NISN</th>
                                    <th>Asal SLTA</th>
                                    <th>Program Studi</th>
                                    <th>Rencana Kelas</th>
                                    <th>Bukti Pembayaran</th>
                                    <th>Tanggal Daftar</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Ambil parameter
                                $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
                                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                                $offset = ($page - 1) * $limit;
                                $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

                                // Query pencarian
                                $where = "";
                                if ($search != '') {
                                    $where = "WHERE nama_lengkap LIKE '%$search%' 
                                              OR nik LIKE '%$search%' 
                                              OR nisn LIKE '%$search%' 
                                              OR email LIKE '%$search%'";
                                }

                                // Hitung total data untuk pagination
                                $total_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tb_pendaftaran $where");
                                $total_data = mysqli_fetch_assoc($total_query)['total'];
                                $total_pages = ceil($total_data / $limit);

                                // Query data
                                $query = mysqli_query($conn, "SELECT * FROM tb_pendaftaran $where ORDER BY id_pendaftaran DESC LIMIT $offset, $limit");

                                $no = $offset + 1;

                                if (mysqli_num_rows($query) > 0) {
                                    while ($row = mysqli_fetch_assoc($query)) {
                                        $badgeClass = 'bg-warning text-dark';
                                        if ($row['status_pendaftaran'] == 'Diterima')
                                            $badgeClass = 'bg-success';
                                        if ($row['status_pendaftaran'] == 'Tidak Diterima')
                                            $badgeClass = 'bg-danger';
                                ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= htmlspecialchars($row['nama_lengkap']); ?></td>
                                            <td><?= htmlspecialchars($row['email']); ?></td>
                                            <td><?= htmlspecialchars($row['jenis_kelamin']); ?></td>
                                            <td><?= htmlspecialchars($row['alamat']); ?></td>
                                            <td><?= htmlspecialchars($row['nik']); ?></td>
                                            <td><?= htmlspecialchars($row['nisn']); ?></td>
                                            <td><?= htmlspecialchars($row['asal_slta']); ?></td>
                                            <td><?= htmlspecialchars($row['program_studi']); ?></td>
                                            <td><?= htmlspecialchars($row['rencana_kelas']); ?></td>
                                            <td>
                                                <?php if (!empty($row['bukti_pembayaran'])) { ?>
                                                    <a href="uploads/<?= $row['bukti_pembayaran']; ?>" target="_blank"
                                                        class="btn btn-sm btn-info text-white">
                                                        <i class="bi bi-eye"></i> Lihat
                                                    </a>
                                                <?php } else { ?>
                                                    <span class="text-muted">Tidak ada</span>
                                                <?php } ?>
                                            </td>
                                            <td><?= date('d-m-Y', strtotime($row['tanggal_daftar'])); ?></td>
                                            <td><span class="badge <?= $badgeClass; ?>"><?= $row['status_pendaftaran']; ?></span></td>
                                            <td>
                                                <a href="pendaftaran_edit.php?id=<?= $row['id_pendaftaran']; ?>"
                                                    class="btn btn-sm btn-warning mb-1" title="Edit Data">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>

                                                <a href="pendaftaran_hapus.php?id=<?= $row['id_pendaftaran']; ?>"
                                                    class="btn btn-sm btn-danger mb-1" title="Hapus Data"
                                                    onclick="return confirm('Yakin ingin menghapus data ini?');">
                                                    <i class="bi bi-trash"></i>
                                                </a>

                                                <form action="registrasi/update_status.php" method="POST" class="d-inline">
                                                    <input type="hidden" name="id_pendaftaran"
                                                        value="<?= $row['id_pendaftaran']; ?>">
                                                    <select name="status" class="form-select form-select-sm d-inline w-auto"
                                                        onchange="this.form.submit()">
                                                        <option value="Pending" <?= ($row['status_pendaftaran'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                                        <option value="Diterima" <?= ($row['status_pendaftaran'] == 'Diterima') ? 'selected' : ''; ?>>Diterima</option>
                                                        <option value="Tidak Diterima" <?= ($row['status_pendaftaran'] == 'Tidak Diterima') ? 'selected' : ''; ?>>Tidak Diterima</option>
                                                    </select>
                                                </form>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='14' class='text-center text-muted'>Tidak ada data ditemukan.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <?php
                    $start_data = ($page - 1) * $limit + 1;
                    $end_data = min($start_data + $limit - 1, $total_data);
                    ?>

                    <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
                        <div class="text-muted small mb-2 mb-md-0">
                            Menampilkan <strong><?= $start_data ?></strong>–<strong><?= $end_data ?></strong> dari
                            <strong><?= $total_data ?></strong> data
                        </div>

                        <nav>
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                                    <a class="page-link"
                                        href="?page=<?= $page - 1 ?>&limit=<?= $limit ?>&search=<?= urlencode($search) ?>">Previous</a>
                                </li>

                                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                    <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                                        <a class="page-link"
                                            href="?page=<?= $i ?>&limit=<?= $limit ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
                                    </li>
                                <?php endfor; ?>

                                <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                                    <a class="page-link"
                                        href="?page=<?= $page + 1 ?>&limit=<?= $limit ?>&search=<?= urlencode($search) ?>">Next</a>
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
