<?php
$host = "localhost";
$user = "root"; // ganti jika pakai user lain
$pass = "";
$db = "pmb_mkm"; // sesuaikan dengan nama database kamu

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>