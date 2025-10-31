<?php
include '../includes/koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data pendaftar (nik dan bukti pembayaran)
    $query = mysqli_query($conn, "SELECT nik, bukti_pembayaran FROM tb_pendaftaran WHERE id_pendaftaran='$id'");
    $data = mysqli_fetch_assoc($query);

    if ($data) {
        $nik = $data['nik'];
        $bukti = $data['bukti_pembayaran'];

        // Hapus file bukti pembayaran jika ada
        if (!empty($bukti) && file_exists("uploads/" . $bukti)) {
            unlink("uploads/" . $bukti);
        }

        // Hapus data dari tabel pendaftaran
        $deletePendaftaran = mysqli_query($conn, "DELETE FROM tb_pendaftaran WHERE id_pendaftaran='$id'");

        // Hapus akun user di tb_user berdasarkan NIK
        $deleteUser = mysqli_query($conn, "DELETE FROM tb_user WHERE username='$nik'");

        if ($deletePendaftaran && $deleteUser) {
            echo "<script>alert('Data pendaftaran dan akun user berhasil dihapus!'); window.location='data_pendaftaran.php';</script>";
        } elseif ($deletePendaftaran) {
            // Kalau cuma data pendaftaran yang kehapus tapi user nggak ada
            echo "<script>alert('Data pendaftaran berhasil dihapus, tapi akun user tidak ditemukan!'); window.location='data_pendaftaran.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus data!'); window.location='data_pendaftaran.php';</script>";
        }
    } else {
        echo "<script>alert('Data pendaftaran tidak ditemukan!'); window.location='data_pendaftaran.php';</script>";
    }
} else {
    header("Location: data_pendaftaran.php");
}
?>
