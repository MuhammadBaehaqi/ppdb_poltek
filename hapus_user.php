<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data user
    $query = mysqli_query($conn, "SELECT username FROM tb_user WHERE id_user='$id'");
    $data = mysqli_fetch_assoc($query);

    if ($data) {
        $username = $data['username'];

        // Hapus user dari tabel tb_user
        $deleteUser = mysqli_query($conn, "DELETE FROM tb_user WHERE id_user='$id'");

        // Jika user terkait pendaftaran, hapus juga datanya (opsional)
        $deletePendaftaran = mysqli_query($conn, "DELETE FROM tb_pendaftaran WHERE nik='$username'");

        if ($deleteUser) {
            echo "<script>alert('User berhasil dihapus!'); window.location='kelola_user.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus user!'); window.location='kelola_user.php';</script>";
        }
    } else {
        echo "<script>alert('User tidak ditemukan!'); window.location='kelola_user.php';</script>";
    }
} else {
    header("Location: kelola_user.php");
    exit;
}
?>
