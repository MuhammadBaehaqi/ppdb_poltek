<?php
include '../koneksi.php';

if (isset($_POST['id_pendaftaran']) && isset($_POST['status'])) {
    $id_pendaftaran = $_POST['id_pendaftaran'];
    $status = $_POST['status'];

    // Ambil NIK dari tabel pendaftaran
    $result = mysqli_query($conn, "SELECT nik FROM tb_pendaftaran WHERE id_pendaftaran='$id_pendaftaran'");
    $data = mysqli_fetch_assoc($result);
    $nik = $data['nik'];

    // Update status pendaftaran
    mysqli_query($conn, "UPDATE tb_pendaftaran SET status_pendaftaran='$status' WHERE id_pendaftaran='$id_pendaftaran'");

    // Update status akun di tb_user
    if ($status == 'Diterima') {
        mysqli_query($conn, "UPDATE tb_user SET status_akun='aktif' WHERE username='$nik'");
    } else {
        mysqli_query($conn, "UPDATE tb_user SET status_akun='nonaktif' WHERE username='$nik'");
    }

    echo "<script>alert('Status berhasil diperbarui!');window.location='../data_pendaftaran.php';</script>";
}
?>
