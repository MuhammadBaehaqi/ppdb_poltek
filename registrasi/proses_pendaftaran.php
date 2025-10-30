<?php
include '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_lengkap = $_POST['nama_lengkap'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $alamat = $_POST['alamat'];
    $nik = $_POST['nik'];
    $nisn = $_POST['nisn'];
    $asal_slta = $_POST['asal_slta'];
    $program_studi = $_POST['program_studi'];
    $rencana_kelas = $_POST['rencana_kelas'];

    // Upload file bukti pembayaran
    $target_dir = "../uploads/";
    $file_name = time() . "_" . basename($_FILES["bukti_pembayaran"]["name"]);
    $target_file = $target_dir . $file_name;
    move_uploaded_file($_FILES["bukti_pembayaran"]["tmp_name"], $target_file);

    // Simpan ke tabel pendaftaran
    $sql1 = "INSERT INTO tb_pendaftaran 
            (nama_lengkap, jenis_kelamin, alamat, nik, nisn, asal_slta, program_studi, rencana_kelas, bukti_pembayaran)
            VALUES ('$nama_lengkap', '$jenis_kelamin', '$alamat', '$nik', '$nisn', '$asal_slta', '$program_studi', '$rencana_kelas', '$file_name')";

    if (mysqli_query($conn, $sql1)) {
        // Buat akun user otomatis
        $password_hashed = password_hash($nik, PASSWORD_DEFAULT);
        $sql2 = "INSERT INTO tb_user (nama_lengkap, username, password, role, status_akun)
                 VALUES ('$nama_lengkap', '$nik', '$password_hashed', 'mahasiswa', 'nonaktif')";
        mysqli_query($conn, $sql2);

        echo "<script>alert('Pendaftaran berhasil! Akun Anda telah dibuat, tunggu verifikasi admin.');window.location='../index.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan, silakan coba lagi.');window.history.back();</script>";
    }
}
?>
