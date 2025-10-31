<?php

include 'koneksi.php';

$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM tb_pendaftaran WHERE id_pendaftaran = '$id'");
$row = mysqli_fetch_assoc($data);

if (isset($_POST['update'])) {
    $nama_lengkap = $_POST['nama_lengkap'];
    $email = $_POST['email'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $alamat = $_POST['alamat'];
    $nik = $_POST['nik'];
    $nisn = $_POST['nisn'];
    $asal_slta = $_POST['asal_slta'];
    $program_studi = $_POST['program_studi'];
    $rencana_kelas = $_POST['rencana_kelas'];
    $status_pendaftaran = $_POST['status_pendaftaran'];

    $query = "UPDATE tb_pendaftaran SET 
            nama_lengkap='$nama_lengkap', 
            email='$email', 
            jenis_kelamin='$jenis_kelamin', 
            alamat='$alamat', 
            nik='$nik', 
            nisn='$nisn', 
            asal_slta='$asal_slta', 
            program_studi='$program_studi', 
            rencana_kelas='$rencana_kelas', 
            status_pendaftaran='$status_pendaftaran'
            WHERE id_pendaftaran='$id'";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data berhasil diperbarui!'); window.location='data_pendaftaran.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data!');</script>";
    }
}
?>

<?php
require_once 'includes/auth.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Pendaftaran</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" href="img/logo_mkm.png" type="image/x-icon">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .content {
            margin-left: 260px;
            padding: 90px 20px;
        }

        @media (max-width: 768px) {
            .content {
                margin-left: 0 !important;
                padding-top: 100px !important;
            }

            .table {
                font-size: 14px;
            }

            table th,
            table td {
                display: block;
                width: 100%;
                text-align: left;
            }

            tr {
                display: block;
                margin-bottom: 15px;
                border: 1px solid #dee2e6;
                border-radius: 10px;
                background: #fff;
                padding: 10px;
            }

            th {
                background: #0d6efd;
                color: white;
                border-top-left-radius: 10px;
                border-top-right-radius: 10px;
                padding: 8px;
            }
        }
    </style>
</head>
<!-- ✅ Sidebar & Navbar dimasukkan di sini -->
<?php include 'sidebar_admin.php'; ?>
<body>
    <div class="content">
        <div class="container">
            <h3 class="fw-bold mb-4"><i class="bi bi-pencil-square me-2"></i>Edit Data Pendaftaran</h3>

            <form method="POST">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Nama Lengkap</th>
                                <td><input type="text" name="nama_lengkap"
                                        value="<?= htmlspecialchars($row['nama_lengkap']); ?>" class="form-control"
                                        required></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><input type="email" name="email" value="<?= htmlspecialchars($row['email']); ?>"
                                        class="form-control" required></td>
                            </tr>
                            <tr>
                                <th>Jenis Kelamin</th>
                                <td>
                                    <select name="jenis_kelamin" class="form-select" required>
                                        <option value="Laki-laki" <?= ($row['jenis_kelamin'] == "Laki-laki") ? 'selected' : ''; ?>>Laki-laki</option>
                                        <option value="Perempuan" <?= ($row['jenis_kelamin'] == "Perempuan") ? 'selected' : ''; ?>>Perempuan</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td><input type="text" name="alamat" value="<?= htmlspecialchars($row['alamat']); ?>"
                                        class="form-control" required></td>
                            </tr>
                            <tr>
                                <th>NIK</th>
                                <td><input type="text" name="nik" value="<?= htmlspecialchars($row['nik']); ?>"
                                        class="form-control" required></td>
                            </tr>
                            <tr>
                                <th>NISN</th>
                                <td><input type="text" name="nisn" value="<?= htmlspecialchars($row['nisn']); ?>"
                                        class="form-control" required></td>
                            </tr>
                            <tr>
                                <th>Asal SLTA</th>
                                <td><input type="text" name="asal_slta"
                                        value="<?= htmlspecialchars($row['asal_slta']); ?>" class="form-control"
                                        required></td>
                            </tr>
                            <tr>
                                <th>Program Studi</th>
                                <td>
                                    <select name="program_studi" class="form-select" required>
                                        <option value="Analis Kesehatan" <?= ($row['program_studi'] == "Analis Kesehatan") ? 'selected' : ''; ?>>Analis Kesehatan</option>
                                        <option value="Farmasi" <?= ($row['program_studi'] == "Farmasi") ? 'selected' : ''; ?>>
                                            Farmasi</option>
                                        <option value="Manajemen Informatika" <?= ($row['program_studi'] == "Manajemen Informatika") ? 'selected' : ''; ?>>Manajemen Informatika</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>Rencana Kelas</th>
                                <td>
                                    <select name="rencana_kelas" class="form-select" required>
                                        <option value="Kelas Reguler" <?= ($row['rencana_kelas'] == "Kelas Reguler") ? 'selected' : ''; ?>>Kelas Reguler</option>
                                        <option value="Kelas Karyawan" <?= ($row['rencana_kelas'] == "Kelas Karyawan") ? 'selected' : ''; ?>>Kelas Karyawan</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>Status Pendaftaran</th>
                                <td>
                                    <select name="status_pendaftaran" class="form-select" required>
                                        <option value="Pending"
                                            <?= ($row['status_pendaftaran'] == "Pending") ? 'selected' : ''; ?>>Pending
                                        </option>
                                        <option value="Diterima"
                                            <?= ($row['status_pendaftaran'] == "Diterima") ? 'selected' : ''; ?>>Diterima
                                        </option>
                                        <option value="Tidak Diterima" <?= ($row['status_pendaftaran'] == "Tidak Diterima") ? 'selected' : ''; ?>>Tidak Diterima</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>Tanggal Daftar</th>
                                <td><input type="text" value="<?= date('d-m-Y', strtotime($row['tanggal_daftar'])); ?>"
                                        class="form-control" readonly></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <button type="submit" name="update" class="btn btn-primary"><i class="bi bi-save2 me-1"></i>
                    Update</button>
                <a href="data_pendaftaran.php" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>