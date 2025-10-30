<?php
session_start();
include '../koneksi.php';

// Pastikan user login
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php?pesan=belum_login");
    exit();
}

// Cek role mahasiswa
if ($_SESSION['role'] !== 'mahasiswa') {
    header("Location: ../login.php?pesan=akses_ditolak");
    exit();
}

$nik = $_SESSION['username'];

// Ambil data pendaftaran user
$query = mysqli_query($conn, "SELECT * FROM tb_pendaftaran WHERE nik = '$nik' LIMIT 1");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "<script>alert('Data biodata tidak ditemukan!');window.location='dashboard_user.php';</script>";
    exit();
}

// Proses update biodata
if (isset($_POST['update_biodata'])) {
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $update = mysqli_query($conn, "UPDATE tb_pendaftaran SET alamat='$alamat', email='$email' WHERE nik='$nik'");

    if ($update) {
        echo "<script>alert('Data berhasil diperbarui!');window.location='pengaturan.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data!');</script>";
    }
}

// Proses ganti password
if (isset($_POST['update_password'])) {
    $password_lama = $_POST['password_lama'];
    $password_baru = $_POST['password_baru'];
    $konfirmasi = $_POST['konfirmasi_password'];

    $cek_user = mysqli_query($conn, "SELECT * FROM tb_user WHERE username='$nik' LIMIT 1");
    $user = mysqli_fetch_assoc($cek_user);

    if ($user && password_verify($password_lama, $user['password'])) {
        if ($password_baru === $konfirmasi) {
            $password_hash = password_hash($password_baru, PASSWORD_DEFAULT);
            mysqli_query($conn, "UPDATE tb_user SET password='$password_hash' WHERE username='$nik'");
            echo "<script>alert('Password berhasil diubah!');window.location='pengaturan.php';</script>";
        } else {
            echo "<script>alert('Konfirmasi password tidak cocok!');</script>";
        }
    } else {
        echo "<script>alert('Password lama salah!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Pengaturan Akun</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="../img/logo_mkm.png" type="image/x-icon">
    <style>
        body {
            background-color: #f8f9fa;
        }

        /* Pastikan konten tidak ketumpuk navbar */
        .content {
            margin-left: 250px;
            /* sesuai lebar sidebar */
            padding: 100px 30px 50px;
            /* tambahkan jarak dari atas karena navbar fixed */
            min-height: 100vh;
            overflow-y: auto;
            /* biar bisa discroll */
        }

        /* Responsif mobile */
        @media (max-width: 991.98px) {
            .content {
                margin-left: 0;
                padding-top: 100px;
            }
        }


        .card {
            border: none;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
        }

        @media (max-width: 768px) {
            .sidebar {
                left: -240px;
                transition: 0.3s;
            }

            .sidebar.show {
                left: 0;
            }

            .content {
                margin-left: 0;
                padding-top: 70px;
            }

            .toggle-btn {
                position: fixed;
                top: 15px;
                left: 15px;
                background-color: #004b3b;
                color: white;
                border: none;
                padding: 8px 12px;
                border-radius: 5px;
                z-index: 2000;
            }
        }
    </style>
</head>

<body>
    <?php include 'sidebar_user.php'; ?>

    <div class="content">
        <div class="container">
            <h4 class="fw-bold mb-4 text-success">⚙️ Pengaturan Akun</h4>

            <!-- Edit Biodata -->
            <div class="card mb-4 p-4">
                <h5 class="fw-bold text-dark mb-3">🧾 Edit Biodata</h5>
                <div class="alert alert-warning py-2 mb-3">
                    <b>Perhatian:</b> Hanya kolom <b>Alamat & Email</b> yang dapat diubah.
                    Data lainnya bersifat tetap. Jika terdapat kesalahan data, segera hubungi <b>Admin</b>.
                </div>

                <form method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="fw-semibold">NIK</label>
                            <input type="text" class="form-control bg-light"
                                value="<?= htmlspecialchars($data['nik']); ?>" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="fw-semibold">NISN</label>
                            <input type="text" class="form-control bg-light"
                                value="<?= htmlspecialchars($data['nisn']); ?>" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="fw-semibold">Nama Lengkap</label>
                            <input type="text" class="form-control bg-light"
                                value="<?= htmlspecialchars($data['nama_lengkap']); ?>" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="fw-semibold">Jenis Kelamin</label>
                            <input type="text" class="form-control bg-light"
                                value="<?= htmlspecialchars($data['jenis_kelamin']); ?>" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="fw-semibold">Asal SLTA</label>
                            <input type="text" class="form-control bg-light"
                                value="<?= htmlspecialchars($data['asal_slta']); ?>" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="fw-semibold">Program Studi</label>
                            <input type="text" class="form-control bg-light"
                                value="<?= htmlspecialchars($data['program_studi']); ?>" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="fw-semibold">Rencana Kelas</label>
                            <input type="text" class="form-control bg-light"
                                value="<?= htmlspecialchars($data['rencana_kelas']); ?>" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="fw-semibold">Alamat</label>
                            <textarea name="alamat"
                                class="form-control"><?= htmlspecialchars($data['alamat']); ?></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="fw-semibold">Email</label>
                            <input type="email" name="email" class="form-control"
                                value="<?= htmlspecialchars($data['email']); ?>">
                        </div>
                    </div>
                    <button type="submit" name="update_biodata" class="btn btn-success mt-2">💾 Simpan
                        Perubahan</button>
                </form>
            </div>

            <!-- Ganti Password -->
            <div class="card p-4 mb-5">
                <h5 class="fw-bold text-dark mb-3">🔒 Ganti Password</h5>
                <form method="POST">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="fw-semibold">Password Lama</label>
                            <input type="password" name="password_lama" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="fw-semibold">Password Baru</label>
                            <input type="password" name="password_baru" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="fw-semibold">Konfirmasi Password Baru</label>
                            <input type="password" name="konfirmasi_password" class="form-control" required>
                        </div>
                    </div>
                    <button type="submit" name="update_password" class="btn btn-success mt-2">🔁 Ubah Password</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const sidebar = document.querySelector('.sidebar');
        function toggleSidebar() {
            sidebar.classList.toggle('show');
        }
    </script>
</body>

</html>