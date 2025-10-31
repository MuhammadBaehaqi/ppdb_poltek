<?php
include 'includes/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $nomor_wa = trim($_POST['nomor_wa']);
    $pesan = trim($_POST['pesan']);

    // Validasi sederhana
    if (empty($nama) || empty($email) || empty($nomor_wa) || empty($pesan)) {
        header("Location: kontak.php?status=gagal&msg=Data tidak boleh kosong");
        exit;
    }

    // Simpan ke database
    $query = "INSERT INTO kontak (nama, email, nomor_wa, pesan) 
              VALUES ('$nama', '$email', '$nomor_wa', '$pesan')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        header("Location: kontak.php?status=sukses&msg=Pesan berhasil dikirim");
    } else {
        header("Location: kontak.php?status=gagal&msg=Terjadi kesalahan saat menyimpan data");
    }
    exit;
} else {
    header("Location: kontak.php");
    exit;
}
?>
