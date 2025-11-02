<?php
include '../includes/koneksi.php';

if (isset($_POST['id_user']) && isset($_POST['status_akun'])) {
    $id_user = $_POST['id_user'];
    $status = $_POST['status_akun'];

    // Ambil username (NIK)
    $getUser = mysqli_query($conn, "SELECT username FROM tb_user WHERE id_user='$id_user'");
    $user = mysqli_fetch_assoc($getUser);
    $nik = $user['username'];

    // Cek status pendaftaran dulu
    $cekPendaftaran = mysqli_query($conn, "SELECT status_pendaftaran FROM tb_pendaftaran WHERE nik='$nik'");
    $dataP = mysqli_fetch_assoc($cekPendaftaran);

    if ($dataP && $dataP['status_pendaftaran'] != 'Diterima' && $status == 'aktif') {
        echo "<script>alert('Tidak bisa mengaktifkan akun karena pendaftar belum diterima!');window.location='../kelola_user.php';</script>";
        exit;
    }

    // Jika lolos, baru update status akun
    $update = mysqli_query($conn, "UPDATE tb_user SET status_akun='$status' WHERE id_user='$id_user'");

    if ($update) {
        echo "<script>alert('Status user berhasil diperbarui!');window.location='../admin/kelola_user.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui status user!');window.location='../admin/kelola_user.php';</script>";
    }
}
?>
