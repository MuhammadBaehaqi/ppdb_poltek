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

        /* ===== SIDEBAR ===== */
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

        /* ===== MAIN CONTENT ===== */
        .main {
            flex: 1;
            padding: 0;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        /* ===== TOPBAR ===== */
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
            background: #212529;
            color: white;
            border: none;
            padding: 8px 18px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
        }

        .topbar button:hover {
            background: #009c74;
        }

        /* ===== CONTENT ===== */
        .content {
            padding: 30px;
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

<?php
// ==== Data contoh biodata mahasiswa ====
$nama          = "Hikmatul Hukamah";
$nim           = "23101001";
$jurusan       = "Teknik Informatika";
$tahun_masuk   = "2023";
$tempat_lahir  = "Brebes";
$tanggal_lahir = "12 Maret 2005";
$jenis_kelamin = "Perempuan";
$email         = "hikmatulhukamah@gmail.com";
$no_hp         = "62 858 7586 3631";
$alamat        = "Jl. Pahlawan No. 17, Kersana, Brebes";
?>

<!-- ===== SIDEBAR ===== -->
<div class="sidebar">
    <img src="img/poltek.png" alt="Logo Poltek" class="logo">
    <div class="brand">POLITEKNIK<br>MITRA KARYA MANDIRI</div>

    <div class="menu">
        <a href="dashboard_user.php">🏠 Dashboard</a>
        <a href="pengaturan.php">⚙️ Pengaturan</a>
    </div>
</div>

<!-- ===== MAIN AREA ===== -->
<div class="main">
    <div class="topbar">
        <h2>Biodata Mahasiswa</h2>
        <button>Logout</button>
    </div>

    <div class="content">
        <div class="profile">
            <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" alt="User Avatar">
            <div>
                <h3><?= $nama ?></h3>
                <p><b>NIM:</b> <?= $nim ?></p>
                <p><b>Program Studi:</b> <?= $jurusan ?></p>
            </div>
        </div>

        <div class="biodata">
            <h3>Detail Biodata</h3>
            <hr style="margin: 15px 0;">

            <table>
                <tr><th>Nama Lengkap</th><td><?= $nama ?></td></tr>
                <tr><th>NIM</th><td><?= $nim ?></td></tr>
                <tr><th>Program Studi</th><td><?= $jurusan ?></td></tr>
                <tr><th>Tahun Masuk</th><td><?= $tahun_masuk ?></td></tr>
                <tr><th>Tempat, Tanggal Lahir</th><td><?= $tempat_lahir ?>, <?= $tanggal_lahir ?></td></tr>
                <tr><th>Jenis Kelamin</th><td><?= $jenis_kelamin ?></td></tr>
                <tr><th>Email</th><td><?= $email ?></td></tr>
                <tr><th>No HP/WA</th><td><?= $no_hp ?></td></tr>
                <tr><th>Alamat</th><td><?= $alamat ?></td></tr>
            </table>
        </div>

        <footer>
            &copy; <?= date('Y') ?> POLITEKNIK MITRA KARYA MANDIRI — Sistem Informasi Akademik
        </footer>
    </div>
</div>

</body>
</html>
