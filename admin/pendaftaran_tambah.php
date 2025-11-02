<?php
include '../includes/koneksi.php';

if (isset($_POST['simpan'])) {
    $nama_lengkap = $_POST['nama_lengkap'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $alamat = $_POST['alamat'];
    $email = $_POST['email']; // ✅ Tambah email
    $nik = $_POST['nik'];
    $nisn = $_POST['nisn'];
    $asal_slta = $_POST['asal_slta'];
    $program_studi = $_POST['program_studi'];
    $rencana_kelas = $_POST['rencana_kelas'];
    $status_pendaftaran = "Pending";

    if (!empty($_FILES['bukti_pembayaran']['name'])) {
        $fileName = time() . "_" . $_FILES['bukti_pembayaran']['name'];
        $targetDir = "../uploads/";
        move_uploaded_file($_FILES['bukti_pembayaran']['tmp_name'], $targetDir . $fileName);
        $bukti_pembayaran = $fileName;
    } else {
        echo "<script>alert('Bukti pembayaran wajib diunggah!'); window.history.back();</script>";
        exit;
    }

    // ✅ Tambahkan kolom email ke query INSERT
    $query = "INSERT INTO tb_pendaftaran 
              (nama_lengkap, jenis_kelamin, alamat, email, nik, nisn, asal_slta, program_studi, rencana_kelas, bukti_pembayaran, status_pendaftaran, tanggal_daftar) 
              VALUES ('$nama_lengkap', '$jenis_kelamin', '$alamat', '$email', '$nik', '$nisn', '$asal_slta', '$program_studi', '$rencana_kelas', '$bukti_pembayaran', '$status_pendaftaran', NOW())";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data berhasil ditambahkan!'); window.location='data_pendaftaran.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan data!');</script>";
    }
}
?>

<?php
require_once '../includes/auth.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Pendaftaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" href="img/logo_mkm.png" type="image/x-icon">
    <style>
        body { background-color: #f8f9fa; }
        .content { margin-left: 260px; padding: 90px 20px; }
        @media (max-width: 768px) {
            .content { margin-left: 0 !important; padding-top: 100px !important; }
            .table { font-size: 14px; }
            table th, table td { display: block; width: 100%; text-align: left; }
            tr { display: block; margin-bottom: 15px; border: 1px solid #dee2e6; border-radius: 10px; background: #fff; padding: 10px; }
            th { background: #0d6efd; color: white; border-top-left-radius: 10px; border-top-right-radius: 10px; padding: 8px; }
        }
    </style>
</head>

<?php include 'sidebar_admin.php'; ?>

<body>
    <div class="content">
        <div class="container">
            <h3 class="fw-bold mb-4"><i class="bi bi-person-plus-fill me-2"></i>Tambah Pendaftaran</h3>

            <form method="POST" enctype="multipart/form-data">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Nama Lengkap</th>
                                <td><input type="text" name="nama_lengkap" class="form-control" required></td>
                            </tr>
                            <tr>
                                <th>Jenis Kelamin</th>
                                <td>
                                    <select name="jenis_kelamin" class="form-select" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td><input type="text" name="alamat" class="form-control" required></td>
                            </tr>
                            <tr>
                                <th>Email</th> <!-- ✅ Tambah kolom email -->
                                <td><input type="email" name="email" class="form-control" required></td>
                            </tr>
                            <tr>
                                <th>NIK</th>
                                <td><input type="text" name="nik" class="form-control" required></td>
                            </tr>
                            <tr>
                                <th>NISN</th>
                                <td><input type="text" name="nisn" class="form-control" required></td>
                            </tr>
                            <tr>
                                <th>Asal SLTA</th>
                                <td><input type="text" name="asal_slta" class="form-control" required></td>
                            </tr>
                            <tr>
                                <th>Program Studi</th>
                                <td>
                                    <select name="program_studi" class="form-select" required>
                                        <option value="">-- Pilih Jurusan --</option>
                                        <option value="Analis Kesehatan">Analis Kesehatan</option>
                                        <option value="Farmasi">Farmasi</option>
                                        <option value="Manajemen Informatika">Manajemen Informatika</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>Rencana Kelas</th>
                                <td>
                                    <select name="rencana_kelas" class="form-select" required>
                                        <option value="">-- Pilih Kelas --</option>
                                        <option value="Kelas Reguler">Kelas Reguler</option>
                                        <option value="Kelas Karyawan">Kelas Karyawan</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>Bukti Pembayaran</th>
                                <td><input type="file" name="bukti_pembayaran" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <button type="submit" name="simpan" class="btn btn-primary"><i class="bi bi-save2 me-1"></i> Simpan</button>
                <a href="data_pendaftaran.php" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
g