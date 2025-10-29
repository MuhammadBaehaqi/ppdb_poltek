<?php
include 'sidebar_admin.php';
include 'koneksi.php';

$toast_message = "";

// --- Tambah Admin ---
if (isset($_POST['tambah_admin'])) {
    $nama_admin = $_POST['nama_admin'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = 'admin';

    $query = "INSERT INTO admin (nama_admin, username, email, password, role) VALUES ('$nama_admin', '$username', '$email', '$password', '$role')";
    if (mysqli_query($conn, $query)) {
        $toast_message = "Admin baru berhasil ditambahkan!";
    }
}

// --- Update Admin ---
if (isset($_POST['update_admin'])) {
    $id = $_POST['id'];
    $nama_admin = $_POST['nama_admin'];
    $username = $_POST['username'];
    $email = $_POST['email'];

    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $query = "UPDATE admin SET nama_admin='$nama_admin', username='$username', email='$email', password='$password' WHERE id='$id'";
    } else {
        $query = "UPDATE admin SET nama_admin='$nama_admin', username='$username', email='$email' WHERE id='$id'";
    }

    if (mysqli_query($conn, $query)) {
        $toast_message = "Data admin berhasil diperbarui!";
    }
}

// --- Hapus Admin ---
if (isset($_POST['hapus_admin'])) {
    $id = $_POST['id'];
    if (mysqli_query($conn, "DELETE FROM admin WHERE id='$id'")) {
        $toast_message = "Data admin berhasil dihapus!";
    }
}

// --- Pagination + Pencarian ---
$limit = 5; // jumlah data per halaman
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$start = ($page - 1) * $limit;

// pencarian
$cari = isset($_GET['cari']) ? mysqli_real_escape_string($conn, $_GET['cari']) : '';

if (!empty($cari)) {
    $query = "SELECT * FROM admin 
              WHERE nama_admin LIKE '%$cari%' 
              OR username LIKE '%$cari%' 
              OR email LIKE '%$cari%' 
              ORDER BY id DESC 
              LIMIT $start, $limit";
    $countQuery = "SELECT COUNT(*) AS total FROM admin 
                   WHERE nama_admin LIKE '%$cari%' 
                   OR username LIKE '%$cari%' 
                   OR email LIKE '%$cari%'";
} else {
    $query = "SELECT * FROM admin ORDER BY id DESC LIMIT $start, $limit";
    $countQuery = "SELECT COUNT(*) AS total FROM admin";
}

$result = mysqli_query($conn, $query);
$totalData = mysqli_fetch_assoc(mysqli_query($conn, $countQuery))['total'];
$totalPages = ceil($totalData / $limit);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Admin | Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
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
        }

        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1055;
        }
    </style>
</head>

<body>
    <div class="content">
        <div class="container-fluid">
            <h3 class="fw-bold mb-4"><i class="bi bi-person-gear me-2"></i>Kelola Admin</h3>

            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3 flex-wrap gap-2">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
                            <i class="bi bi-plus-circle me-2"></i>Tambah Admin
                        </button>

                        <form class="d-flex" method="get" style="max-width: 300px;">
                            <input type="text" name="cari" class="form-control" placeholder="Cari admin..."
                                value="<?= htmlspecialchars($cari) ?>">
                            <button class="btn btn-outline-secondary ms-2"><i class="bi bi-search"></i></button>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Admin</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Tanggal Dibuat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (mysqli_num_rows($result) > 0) {
                                    $no = $start + 1;
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "
                                <tr>
                                    <td>{$no}</td>
                                    <td>{$row['nama_admin']}</td>
                                    <td>{$row['username']}</td>
                                    <td>{$row['email']}</td>
                                    <td><span class='badge bg-primary'>Admin</span></td>
                                    <td>{$row['tanggal_dibuat']}</td>
                                    <td>
                                        <button class='btn btn-sm btn-warning editBtn'
                                            data-id='{$row['id']}'
                                            data-nama='{$row['nama_admin']}'
                                            data-username='{$row['username']}'
                                            data-email='{$row['email']}'>
                                            <i class='bi bi-pencil'></i>
                                        </button>
                                        <button class='btn btn-sm btn-danger deleteBtn'
                                            data-id='{$row['id']}'
                                            data-nama='{$row['nama_admin']}'>
                                            <i class='bi bi-trash'></i>
                                        </button>
                                    </td>
                                </tr>";
                                        $no++;
                                    }
                                } else {
                                    echo "<tr><td colspan='7' class='text-center text-muted'>Belum ada data admin</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <nav>
                        <ul class="pagination justify-content-center">
                            <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                                <a class="page-link"
                                    href="?page=<?= $page - 1 ?>&cari=<?= urlencode($cari) ?>">Previous</a>
                            </li>

                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                                    <a class="page-link" href="?page=<?= $i ?>&cari=<?= urlencode($cari) ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>

                            <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                                <a class="page-link" href="?page=<?= $page + 1 ?>&cari=<?= urlencode($cari) ?>">Next</a>
                            </li>
                        </ul>
                    </nav>

                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notifikasi -->
    <?php if (!empty($toast_message)): ?>
        <div class="toast-container">
            <div class="toast align-items-center text-white bg-success border-0 show" role="alert">
                <div class="d-flex">
                    <div class="toast-body fw-semibold">
                        <i class="bi bi-check-circle me-2"></i><?= $toast_message; ?>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Modal Tambah -->
    <div class="modal fade" id="modalTambah" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Admin Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label">Nama Admin</label><input type="text" name="nama_admin"
                            class="form-control" required></div>
                    <div class="mb-3"><label class="form-label">Username</label><input type="text" name="username"
                            class="form-control" required></div>
                    <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email"
                            class="form-control" required></div>
                    <div class="mb-3"><label class="form-label">Password</label><input type="password" name="password"
                            class="form-control" required></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="tambah_admin" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="modalEdit" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" class="modal-content">
                <input type="hidden" name="id" id="editId">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label">Nama Admin</label><input type="text" name="nama_admin"
                            id="editNama" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label">Username</label><input type="text" name="username"
                            id="editUsername" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email"
                            id="editEmail" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label">Password (kosongkan jika tidak diubah)</label><input
                            type="password" name="password" class="form-control"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="update_admin" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Hapus -->
    <div class="modal fade" id="modalHapus" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" class="modal-content">
                <input type="hidden" name="id" id="hapusId">
                <div class="modal-header">
                    <h5 class="modal-title text-danger"><i class="bi bi-exclamation-triangle me-2"></i>Konfirmasi Hapus
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus admin <strong id="hapusNama"></strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="hapus_admin" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.editBtn').forEach(btn => {
            btn.addEventListener('click', function () {
                document.getElementById('editId').value = this.dataset.id;
                document.getElementById('editNama').value = this.dataset.nama;
                document.getElementById('editUsername').value = this.dataset.username;
                document.getElementById('editEmail').value = this.dataset.email;
                new bootstrap.Modal(document.getElementById('modalEdit')).show();
            });
        });

        document.querySelectorAll('.deleteBtn').forEach(btn => {
            btn.addEventListener('click', function () {
                document.getElementById('hapusId').value = this.dataset.id;
                document.getElementById('hapusNama').textContent = this.dataset.nama;
                new bootstrap.Modal(document.getElementById('modalHapus')).show();
            });
        });
    </script>
</body>

</html>