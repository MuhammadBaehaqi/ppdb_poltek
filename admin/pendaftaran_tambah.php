<?php
include '../includes/koneksi.php';

if (isset($_POST['simpan'])) {
    $nama_lengkap = $_POST['nama_lengkap'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $alamat = $_POST['alamat'];
    $email = $_POST['email']; 
    $nomor_wa = $_POST['nomor_wa'];
    // Normalisasi nomor WA
    $nomor_wa = preg_replace('/[^0-9]/', '', $nomor_wa); // hanya angka
    if (substr($nomor_wa, 0, 1) === '0') {
        $nomor_wa = '+62' . substr($nomor_wa, 1);
    } elseif (substr($nomor_wa, 0, 2) === '62') {
        $nomor_wa = '+' . $nomor_wa;
    } elseif (substr($nomor_wa, 0, 3) !== '+62') {
        $nomor_wa = '+62' . $nomor_wa;
    }
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

    // ✅ Tambahkan kolom nomor_wa ke query
    $query = "INSERT INTO tb_pendaftaran 
              (nama_lengkap, jenis_kelamin, alamat, email, nomor_wa, nik, nisn, asal_slta, program_studi, rencana_kelas, bukti_pembayaran, status_pendaftaran, tanggal_daftar) 
              VALUES ('$nama_lengkap', '$jenis_kelamin', '$alamat', '$email', '$nomor_wa', '$nik', '$nisn', '$asal_slta', '$program_studi', '$rencana_kelas', '$bukti_pembayaran', '$status_pendaftaran', NOW())";

    if (mysqli_query($conn, $query)) {

    // 🔹 Buat akun otomatis (seperti proses_pendaftaran.php)
    $password_hashed = password_hash($nik, PASSWORD_DEFAULT);

    // Cek apakah user sudah ada di tb_user
    $cekUser = mysqli_query($conn, "SELECT username FROM tb_user WHERE username = '$nik'");
    if (mysqli_num_rows($cekUser) == 0) {
        // Status akun aktif kalau status pendaftaran Diterima, kalau tidak nonaktif
        $status_akun = ($status_pendaftaran === 'Diterima') ? 'aktif' : 'nonaktif';

        $sql_user = "INSERT INTO tb_user (nama_lengkap, username, password, role, status_akun, tanggal_daftar)
                     VALUES ('$nama_lengkap', '$nik', '$password_hashed', 'mahasiswa', '$status_akun', NOW())";
        mysqli_query($conn, $sql_user);
    }

    echo "<script>alert('Data berhasil ditambahkan! Akun otomatis telah dibuat.'); window.location='data_pendaftaran.php';</script>";

} else {
    echo "<script>alert('Gagal menambahkan data!');</script>";
}
}
?>

<?php require_once '../includes/auth.php'; ?>

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
                                <th>Email</th>
                                <td><input type="email" name="email" class="form-control" required></td>
                            </tr>
                            <tr>
                                <th>Nomor WhatsApp</th> 
                                <td><input type="text" name="nomor_wa" class="form-control" required></td>
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
</body>
</html>
