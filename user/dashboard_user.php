<?php
session_start();


// Cek apakah sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php?pesan=belum_login");
    exit();
}

// Cek apakah role user
if ($_SESSION['role'] !== 'user') {
    header("Location: login.php?pesan=akses_ditolak");
    exit();
}

// Kalau lolos dua pengecekan di atas, lanjut tampilkan halaman dashboard

include '../koneksi.php';

// Cek apakah sudah login
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit;
}

$nik = $_SESSION['username']; // NIK = username mahasiswa
$query = mysqli_query($conn, "SELECT * FROM tb_pendaftaran WHERE nik = '$nik' LIMIT 1");
$data = mysqli_fetch_assoc($query);

// Jika data tidak ditemukan
if (!$data) {
    echo "<script>alert('Data pendaftaran tidak ditemukan!');window.location='../login.php';</script>";
    exit;
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Biodata Mahasiswa</title>
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
            height: 100vh;
            overflow: hidden;
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

        .menu a:hover,
        .menu a.active {
            background-color: #393a3a;
        }

        .main {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: white;
            padding: 15px 30px;
            border-bottom: 1px solid #ddd;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
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
            padding: 30px;
            overflow-y: auto;
        }

        .profile {
            background: white;
            padding: 20px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        .profile img {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            margin-right: 25px;
        }

        .biodata {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            margin-top: 25px;
        }

        .biodata table {
            width: 100%;
            border-collapse: collapse;
        }

        .biodata th, .biodata td {
            padding: 10px 12px;
            text-align: left;
        }

        .biodata th {
            width: 200px;
            color: #004b3b;
        }

        .biodata tr:nth-child(even) {
            background: #f9fafb;
        }

        footer {
            text-align: center;
            margin: 30px 0;
            color: #777;
            font-size: 14px;
        }
    </style>
</head>
<body>

<!-- ===== SIDEBAR ===== -->
<div class="sidebar">
    <img src="../img/poltek.png" alt="Logo Poltek" class="logo">
    <div class="brand">POLITEKNIK<br>MITRA KARYA MANDIRI</div>

    <div class="menu">
        <a href="dashboard_user.php" class="active">🏠 Dashboard</a>
        <a href="pengaturan.php">⚙️ Pengaturan</a>
        <a href="../logout.php">🚪 Logout</a>
    </div>
</div>

<!-- ===== MAIN AREA ===== -->
<div class="main">
    <div class="topbar">
        <h2>Biodata Mahasiswa</h2>
        <button onclick="window.location.href='../logout.php'">Logout</button>
    </div>

    <div class="content">
        <div class="profile">
            <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" alt="User Avatar">
            <div>
                <h3><?= htmlspecialchars($data['nama_lengkap']); ?></h3>
                <p><b>NIK:</b> <?= htmlspecialchars($data['nik']); ?></p>
                <p><b>Program Studi:</b> <?= htmlspecialchars($data['program_studi']); ?></p>
            </div>
        </div>

        <div class="biodata">
            <h3>Detail Biodata</h3>
            <hr style="margin: 15px 0;">

            <table>
                <tr><th>Nama Lengkap</th><td><?= htmlspecialchars($data['nama_lengkap']); ?></td></tr>
                <tr><th>NIK</th><td><?= htmlspecialchars($data['nik']); ?></td></tr>
                <tr><th>NISN</th><td><?= htmlspecialchars($data['nisn']); ?></td></tr>
                <tr><th>Jenis Kelamin</th><td><?= htmlspecialchars($data['jenis_kelamin']); ?></td></tr>
                <tr><th>Asal SLTA</th><td><?= htmlspecialchars($data['asal_slta']); ?></td></tr>
                <tr><th>Program Studi</th><td><?= htmlspecialchars($data['program_studi']); ?></td></tr>
                <tr><th>Rencana Kelas</th><td><?= htmlspecialchars($data['rencana_kelas']); ?></td></tr>
                <tr><th>Alamat</th><td><?= htmlspecialchars($data['alamat']); ?></td></tr>
                <tr><th>Status Pendaftaran</th><td><b><?= htmlspecialchars($data['status_pendaftaran']); ?></b></td></tr>
                <tr><th>Tanggal Daftar</th><td><?= date('d-m-Y', strtotime($data['tanggal_daftar'])); ?></td></tr>
            </table>
        </div>

        <footer>
            &copy; <?= date('Y') ?> POLITEKNIK MITRA KARYA MANDIRI — Sistem Informasi Akademik
        </footer>
    </div>
</div>

</body>
</html>
