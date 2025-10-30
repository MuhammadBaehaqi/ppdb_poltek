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
    $nama_lengkap   = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $jenis_kelamin  = mysqli_real_escape_string($conn, $_POST['jenis_kelamin']);
    $alamat         = mysqli_real_escape_string($conn, $_POST['alamat']);
    $asal_slta      = mysqli_real_escape_string($conn, $_POST['asal_slta']);
    $program_studi  = mysqli_real_escape_string($conn, $_POST['program_studi']);
    $rencana_kelas  = mysqli_real_escape_string($conn, $_POST['rencana_kelas']);

    $update = mysqli_query($conn, "UPDATE tb_pendaftaran SET 
        nama_lengkap='$nama_lengkap',
        jenis_kelamin='$jenis_kelamin',
        alamat='$alamat',
        asal_slta='$asal_slta',
        program_studi='$program_studi',
        rencana_kelas='$rencana_kelas'
        WHERE nik='$nik'
    ");

    if ($update) {
        echo "<script>alert('Biodata berhasil diperbarui!');window.location='pengaturan.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui biodata!');</script>";
    }
}

// Proses ganti password
if (isset($_POST['update_password'])) {
    $password_lama = $_POST['password_lama'];
    $password_baru = $_POST['password_baru'];
    $konfirmasi = $_POST['konfirmasi_password'];

    // Ambil data dari tb_user
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
            overflow-x: hidden;
        }
        .sidebar {
            width: 240px;
            background-color: #212529;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 20px;
        }
        .sidebar img.logo {
            width: 80px;
            height: 80px;
            margin-bottom: 10px;
            border-radius: 50%;
        }
        .sidebar .brand {
            font-size: 0.95rem;
            text-align: center;
            font-weight: bold;
            line-height: 1.3;
            padding: 0 15px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }
        .menu {
            padding: 20px;
            width: 100%;
        }
        .menu a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 12px 15px;
            margin-bottom: 10px;
            border-radius: 6px;
            transition: background 0.3s;
        }
        .menu a:hover, .menu a.active {
            background-color: #393a3a;
        }
        .main {
            flex: 1;
            padding: 30px;
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

<!-- Sidebar -->
<div class="sidebar">
    <img src="../img/poltek.png" alt="Logo Poltek" class="logo">
    <div class="brand">POLITEKNIK<br>MITRA KARYA MANDIRI</div>

    <div class="menu">
        <a href="dashboard_user.php">🏠 Dashboard</a>
        <a href="pengaturan.php" class="active">⚙️ Pengaturan</a>
        <a href="../logout.php">🚪 Logout</a>
    </div>
</div>

<!-- Main Content -->
<div class="main">
    <h3 class="mb-4 text-success fw-bold">Pengaturan Akun</h3>

    <!-- Form Edit Biodata -->
    <div class="card p-4">
        <h5 class="fw-bold mb-3">🧾 Edit Biodata</h5>
        <form method="POST">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control" value="<?= htmlspecialchars($data['nama_lengkap']); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-select" required>
                        <option value="Laki-laki" <?= ($data['jenis_kelamin']=='Laki-laki')?'selected':''; ?>>Laki-laki</option>
                        <option value="Perempuan" <?= ($data['jenis_kelamin']=='Perempuan')?'selected':''; ?>>Perempuan</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Asal SLTA</label>
                    <input type="text" name="asal_slta" class="form-control" value="<?= htmlspecialchars($data['asal_slta']); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Program Studi</label>
                    <input type="text" name="program_studi" class="form-control" value="<?= htmlspecialchars($data['program_studi']); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Rencana Kelas</label>
                    <input type="text" name="rencana_kelas" class="form-control" value="<?= htmlspecialchars($data['rencana_kelas']); ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Alamat</label>
                    <textarea name="alamat" class="form-control" rows="2"><?= htmlspecialchars($data['alamat']); ?></textarea>
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

</body>
</html>
