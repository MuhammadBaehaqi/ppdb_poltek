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

// Proses update biodata (alamat + email)
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
            display: flex;
            min-height: 100vh;
       
        }

        .main {
            flex: 1;
            display: flex;
            flex-direction: column;
            margin-left: 240px; /* Biar sejajar sama sidebar */
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: white;
            padding: 15px 30px;
            border-bottom: 1px solid #ddd;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            position: fixed;
            width: calc(100% - 240px);
            z-index: 10;
        }

        .topbar h2 {
            color: #004b3b;
        }

        .topbar button {
            background: #dc3545;
            color: white;
            border: none;
            padding: 8px 18px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
        }

        .topbar button:hover {
            background: #bb2d3b;
        }

        .content {
            padding: 100px 30px 30px;
            overflow-y: auto;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .btn-save {
            background-color: #004b3b;
            color: white;
        }

        .btn-save:hover {
            background-color: #01694f;
        }
    </style>
</head>
<body>

    <?php include 'sidebar_user.php'; ?>

    <div class="main">
        <div class="topbar">
            <h2>Pengaturan Akun</h2>
            <button onclick="window.location.href='../logout.php'">Logout</button>
        </div>

        <div class="content">

            <!-- Form Edit Biodata -->
            <div class="card p-4">
                <h5 class="fw-bold mb-3">🧾 Edit Biodata</h5>
                <p class="text-muted mb-3" style="background:#f1f1f1; padding:10px; border-radius:6px;">
                    ⚠️ <b>Perhatian:</b> Hanya kolom <b>Alamat & Email</b> yang dapat diubah. 
                    Data lainnya bersifat tetap. Jika terdapat kesalahan data, segera hubungi <b>Admin</b>.
                </p>

                <form method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>NIK</label>
                            <input type="text" name="nik" class="form-control bg-light" 
                                value="<?= htmlspecialchars($data['nik']); ?>" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>NISN</label>
                            <input type="text" name="nisn" class="form-control bg-light" 
                                value="<?= htmlspecialchars($data['nisn']); ?>" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control bg-light" 
                                value="<?= htmlspecialchars($data['nama_lengkap']); ?>" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Jenis Kelamin</label>
                            <input type="text" name="jenis_kelamin" class="form-control bg-light" 
                                value="<?= htmlspecialchars($data['jenis_kelamin']); ?>" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Asal SLTA</label>
                            <input type="text" name="asal_slta" class="form-control bg-light" 
                                value="<?= htmlspecialchars($data['asal_slta']); ?>" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Program Studi</label>
                            <input type="text" name="program_studi" class="form-control bg-light" 
                                value="<?= htmlspecialchars($data['program_studi']); ?>" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Rencana Kelas</label>
                            <input type="text" name="rencana_kelas" class="form-control bg-light" 
                                value="<?= htmlspecialchars($data['rencana_kelas']); ?>" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Alamat</label>
                            <textarea name="alamat" class="form-control" rows="2"
                                style="background-color: #fff;"><?= htmlspecialchars($data['alamat']); ?></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" 
                                value="<?= htmlspecialchars($data['email']); ?>">
                        </div>
                    </div>
                    <button type="submit" name="update_biodata" class="btn btn-save px-4 mt-2">💾 Simpan Perubahan</button>
                </form>
            </div>

            <!-- Form Ganti Password -->
            <div class="card p-4">
                <h5 class="fw-bold mb-3">🔒 Ganti Password</h5>
                <form method="POST">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>Password Lama</label>
                            <input type="password" name="password_lama" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Password Baru</label>
                            <input type="password" name="password_baru" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Konfirmasi Password Baru</label>
                            <input type="password" name="konfirmasi_password" class="form-control" required>
                        </div>
                    </div>
                    <button type="submit" name="update_password" class="btn btn-save px-4 mt-2">🔁 Ubah Password</button>
                </form>
            </div>

        </div>
    </div>

</body>
</html>
