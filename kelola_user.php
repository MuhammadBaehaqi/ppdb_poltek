<?php

include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola User | Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" href="img/logo_mkm.png" type="image/x-icon">
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
    <!-- ✅ Sidebar & Navbar dimasukkan di sini -->
    <?php include 'sidebar_admin.php'; ?>

    <!-- Konten Utama -->
    <div class="content">
        <div class="container-fluid">
            <h3 class="fw-bold mb-4"><i class="bi bi-people-fill me-2"></i>Kelola User</h3>

            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-end mb-3">
                        <form method="GET" class="d-flex" style="max-width: 300px;">
                            <input type="text" name="keyword"
                                value="<?= isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : ''; ?>"
                                class="form-control" placeholder="Cari nama/NIK...">
                            <button class="btn btn-outline-secondary ms-1" type="submit"><i
                                    class="bi bi-search"></i></button>
                        </form>
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
                                $no = 1;
                                $keyword = isset($_GET['keyword']) ? mysqli_real_escape_string($conn, $_GET['keyword']) : '';

                                if (!empty($keyword)) {
                                    $sql = "SELECT * FROM tb_user 
            WHERE nama_lengkap LIKE '%$keyword%' 
               OR username LIKE '%$keyword%' 
            ORDER BY id_user DESC";
                                } else {
                                    $sql = "SELECT * FROM tb_user ORDER BY id_user DESC";
                                }

                                $query = mysqli_query($conn, $sql);

                                if (mysqli_num_rows($query) > 0) {
                                    while ($row = mysqli_fetch_assoc($query)) {
                                        $badgeClass = ($row['status_akun'] == 'aktif') ? 'bg-success' : 'bg-secondary';
                                        ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= htmlspecialchars($row['nama_lengkap']); ?></td>
                                            <td><?= htmlspecialchars($row['username']); ?></td>
                                            <td><?= ucfirst($row['role']); ?></td>
                                            <td><?= date('d-m-Y H:i', strtotime($row['tanggal_daftar'])); ?></td>
                                            <td><span
                                                    class="badge <?= $badgeClass; ?>"><?= ucfirst($row['status_akun']); ?></span>
                                            </td>
                                            <td>
                                                <!-- Ubah Status -->
                                                <form action="registrasi/update_status_user.php" method="POST" class="d-inline">
                                                    <input type="hidden" name="id_user" value="<?= $row['id_user']; ?>">
                                                    <select name="status_akun"
                                                        class="form-select form-select-sm d-inline w-auto"
                                                        onchange="this.form.submit()">
                                                        <option value="aktif" <?= ($row['status_akun'] == 'aktif') ? 'selected' : ''; ?>>Aktif</option>
                                                        <option value="nonaktif" <?= ($row['status_akun'] == 'nonaktif') ? 'selected' : ''; ?>>Nonaktif</option>
                                                    </select>
                                                </form>
                                                <a href="hapus_user.php?id=<?= $row['id_user']; ?>"
                                                    class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Yakin ingin menghapus user ini?');"><i
                                                        class="bi bi-trash"></i></a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='7' class='text-center text-muted'>Belum ada user terdaftar.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination (opsional) -->
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-end">
                            <li class="page-item disabled"><a class="page-link">Previous</a></li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>