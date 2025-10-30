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
    $nama_lengkap = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $jenis_kelamin = mysqli_real_escape_string($conn, $_POST['jenis_kelamin']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $asal_slta = mysqli_real_escape_string($conn, $_POST['asal_slta']);
    $program_studi = mysqli_real_escape_string($conn, $_POST['program_studi']);
    $rencana_kelas = mysqli_real_escape_string($conn, $_POST['rencana_kelas']);

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
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #f4f6f9;
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* SIDEBAR */
        .sidebar {
            width: 240px;
            background: #004b3b;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            transition: 0.3s;
            overflow-y: auto;
            z-index: 100;
        }

        .sidebar.hide {
            left: -240px;
        }

        .toggle-btn {
            position: fixed;
            top: 15px;
            left: 15px;
            background: #004b3b;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 6px;
            cursor: pointer;
            z-index: 101;
        }

        .main {
            flex: 1;
            margin-left: 240px;
            transition: 0.3s;
        }

        .main.full {
            margin-left: 0;
        }

        .content {
            padding: 90px 20px 40px;
            width: 100%;
        }

        .card {
            background: white;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .card h3 {
            color: #004b3b;
            margin-bottom: 15px;
            border-bottom: 2px solid #004b3b;
            display: inline-block;
            padding-bottom: 5px;
        }

        label {
            display: block;
            margin-top: 10px;
            font-weight: 500;
            color: #333;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            border: 1px solid #ccc;
            border-radius: 6px;
            transition: 0.2s;
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: #004b3b;
            outline: none;
        }

        .btn-save {
            background-color: #004b3b;
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 6px;
            margin-top: 15px;
            cursor: pointer;
            font-weight: 500;
        }

        .btn-save:hover {
            background-color: #01694f;
        }

        footer {
            text-align: center;
            margin-top: 40px;
            color: #777;
            font-size: 14px;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .sidebar {
                left: -240px;
            }

            .sidebar.show {
                left: 0;
            }

            .main {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
    <?php include 'sidebar_user.php'; ?>

    <button class="toggle-btn" onclick="toggleSidebar()">☰</button>

    <div class="main" id="main-content">
        <div class="content">
            <div class="card">
                <h3>🧾 Edit Biodata</h3>
                <form method="POST">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" value="<?= htmlspecialchars($data['nama_lengkap']); ?>"
                        required>

                    <label>Jenis Kelamin</label>
                    <select name="jenis_kelamin" required>
                        <option value="Laki-laki" <?= ($data['jenis_kelamin'] == 'Laki-laki') ? 'selected' : ''; ?>>
                            Laki-laki</option>
                        <option value="Perempuan" <?= ($data['jenis_kelamin'] == 'Perempuan') ? 'selected' : ''; ?>>
                            Perempuan</option>
                    </select>

                    <label>Asal SLTA</label>
                    <input type="text" name="asal_slta" value="<?= htmlspecialchars($data['asal_slta']); ?>">

                    <label>Program Studi</label>
                    <input type="text" name="program_studi" value="<?= htmlspecialchars($data['program_studi']); ?>">

                    <label>Rencana Kelas</label>
                    <input type="text" name="rencana_kelas" value="<?= htmlspecialchars($data['rencana_kelas']); ?>">

                    <label>Alamat</label>
                    <textarea name="alamat" rows="3"><?= htmlspecialchars($data['alamat']); ?></textarea>

                    <button type="submit" name="update_biodata" class="btn-save">💾 Simpan Perubahan</button>
                </form>
            </div>

            <div class="card">
                <h3>🔒 Ganti Password</h3>
                <form method="POST">
                    <label>Password Lama</label>
                    <input type="password" name="password_lama" required>

                    <label>Password Baru</label>
                    <input type="password" name="password_baru" required>

                    <label>Konfirmasi Password Baru</label>
                    <input type="password" name="konfirmasi_password" required>

                    <button type="submit" name="update_password" class="btn-save">🔁 Ubah Password</button>
                </form>
            </div>

            <footer>
                &copy; <?= date('Y') ?> POLITEKNIK MITRA KARYA MANDIRI — Sistem Informasi Akademik
            </footer>
        </div>
    </div>

    <script>
        const sidebar = document.querySelector('.sidebar');
        const mainContent = document.getElementById('main-content');

        function toggleSidebar() {
            sidebar.classList.toggle('show');
            mainContent.classList.toggle('full');
        }
    </script>
</body>

</html>